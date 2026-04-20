<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityAttendance;
use Illuminate\Http\Request;
use App\Models\OrganizationMember;
use Illuminate\Support\Facades\Crypt;
class ActivityAttendanceController extends Controller
{
    public function index(Activity $activity)
    {
        $activity->load('organization');

        $members = $activity->organization
            ->members()
            ->orderBy('full_name')
            ->get();

        $attendanceMap = ActivityAttendance::where('activity_id', $activity->id)
            ->get()
            ->keyBy('member_id');

        return view('attendances.index', compact('activity', 'members', 'attendanceMap'));
    }

    public function store(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'attendances' => 'required|array',
            'attendances.*.member_id' => 'required|exists:organization_members,id',
            'attendances.*.status' => 'required|in:hadir,tidak_hadir,izin',
        ]);

        foreach ($validated['attendances'] as $attendance) {
            ActivityAttendance::updateOrCreate(
                [
                    'activity_id' => $activity->id,
                    'member_id' => $attendance['member_id'],
                ],
                [
                    'status' => $attendance['status'],
                ]
            );
        }

        return redirect()
            ->route('activities.attendances.index', $activity->id)
            ->with('success', 'Absensi berhasil disimpan.');
    }

    public function scanner(Activity $activity)
    {
        $user = auth()->user();

        if (
            !$user->hasRole('super_admin') &&
            !$user->hasRole('admin_desa') &&
            $activity->organization_id != $user->organization_id
        ) {
            abort(403, 'Anda tidak memiliki akses ke scanner absensi ini.');
        }

        return view('activities.scanner', compact('activity'));
    }

    public function myQr()
    {
        $user = auth()->user();
        $member = $user->organizationMember;

        if (!$member) {
            return back()->with('error', 'Akun ini belum terhubung ke data anggota.');
        }

        $payload = Crypt::encryptString(json_encode([
            'member_id' => $member->id,
            'organization_id' => $member->organization_id,
            'exp' => now()->addMinutes(2)->timestamp,
        ]));

        return view('activities.my-qr', compact('member', 'payload'));
    }

    public function scanStore(Request $request, Activity $activity)
    {
        $user = auth()->user();

        if (
            !$user->hasRole('super_admin') &&
            !$user->hasRole('admin_desa') &&
            $activity->organization_id != $user->organization_id
        ) {
            abort(403, 'Anda tidak memiliki akses ke scanner absensi ini.');
        }

        $request->validate([
            'qr_payload' => 'required|string',
        ]);

        try {
            $decoded = json_decode(Crypt::decryptString($request->qr_payload), true);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'QR tidak valid.',
            ], 422);
        }

        if (!$decoded || now()->timestamp > ($decoded['exp'] ?? 0)) {
            return response()->json([
                'success' => false,
                'message' => 'QR sudah kedaluwarsa.',
            ], 422);
        }

        $member = OrganizationMember::find($decoded['member_id'] ?? 0);

        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'Anggota tidak ditemukan.',
            ], 404);
        }

        if ($member->organization_id != $activity->organization_id) {
            return response()->json([
                'success' => false,
                'message' => 'Anggota bukan dari organisasi kegiatan ini.',
            ], 422);
        }

        $attendance = ActivityAttendance::firstOrNew([
            'activity_id' => $activity->id,
            'member_id' => $member->id,
        ]);

        $attendance->status = 'hadir';
        $attendance->checked_in_at = now();
        $attendance->attendance_method = 'qr';
        $attendance->save();

        return response()->json([
            'success' => true,
            'message' => $member->full_name . ' berhasil diabsen.',
            'member_name' => $member->full_name,
        ]);
    }

    /**
     * View for member to scan activity QR
     */
    public function selfScanner()
    {
        return view('activities.self-scanner');
    }

    /**
     * Process self check-in from member scanning activity QR
     */
    public function selfScanStore(Request $request)
    {
        $user = auth()->user();
        $member = $user->organizationMember;

        if (!$member) {
            return response()->json(['success' => false, 'message' => 'Akun Anda tidak terhubung ke data Anggota.'], 403);
        }

        $request->validate([
            'qr_payload' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        try {
            // Decrypt Activity ID
            $activityId = Crypt::decryptString($request->qr_payload);
            $activity = Activity::findOrFail($activityId);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => 'QR Kegiatan tidak valid.'], 422);
        }

        // 1. Validation: Organization match
        if ($member->organization_id != $activity->organization_id) {
            return response()->json(['success' => false, 'message' => 'Kegiatan ini bukan untuk organisasi Anda.'], 422);
        }

        // 2. Validation: GPS Radius (if activity has coordinates)
        if ($activity->latitude && $activity->longitude) {
            $distance = $this->calculateDistance(
                $request->latitude,
                $request->longitude,
                $activity->latitude,
                $activity->longitude
            );

            $radiusLimit = $activity->radius_meter ?? 50;
            if ($distance > $radiusLimit) {
                return response()->json([
                    'success' => false, 
                    'message' => sprintf('Gagal! Lokasi Anda terlalu jauh (%.1f meter). Maksimal %d meter.', $distance, $radiusLimit)
                ], 422);
            }
        }

        // 3. Record Attendance
        $attendance = ActivityAttendance::firstOrNew([
            'activity_id' => $activity->id,
            'member_id' => $member->id,
        ]);

        $attendance->status = 'hadir';
        $attendance->checked_in_at = now();
        $attendance->attendance_method = 'self_qr';
        $attendance->save();

        return response()->json([
            'success' => true,
            'message' => 'Absensi berhasil! Selamat mengikuti kegiatan ' . $activity->title,
        ]);
    }

    /**
     * Show Activity Login QR for admin to display
     */
    public function showActivityQr(Activity $activity)
    {
        $payload = Crypt::encryptString($activity->id);
        return view('activities.activity-qr', compact('activity', 'payload'));
    }

    /**
     * Haversine formula to calculate distance between two points in meters
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // meters

        $latDelta = deg2rad($lat2 - $lat1);
        $lonDelta = deg2rad($lon2 - $lon1);

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($lonDelta / 2) * sin($lonDelta / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}