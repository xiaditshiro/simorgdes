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
}