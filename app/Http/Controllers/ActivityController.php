<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Organization;
use App\Models\OrganizationMember;
use App\Models\Setting;
use Illuminate\Http\Request;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = \App\Models\Activity::with('organization');

        if (!$user->hasRole('super_admin') && !$user->hasRole('admin_desa')) {
            $query->where('organization_id', $user->organization_id);
        }

        if ($request->filled('organization_id')) {
            $query->where('organization_id', $request->organization_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('activity_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('activity_date', '<=', $request->date_to);
        }

        if ($request->filled('keyword')) {
            $query->where('title', 'like', '%' . $request->keyword . '%');
        }

        $activities = $query->latest()->paginate(10)->withQueryString();

        if ($user->hasRole('super_admin') || $user->hasRole('admin_desa')) {
            $organizations = \App\Models\Organization::orderBy('name')->get();
        } else {
            $organizations = \App\Models\Organization::where('id', $user->organization_id)->get();
        }

        return view('activities.index', compact('activities', 'organizations'));
    }

    public function create()
    {
        $user = auth()->user();

        if ($user->hasRole('super_admin') || $user->hasRole('admin_desa')) {
            $organizations = Organization::orderBy('name')->get();
        } else {
            $organizations = Organization::where('id', $user->organization_id)->get();
        }

        return view('activities.create', compact('organizations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'title' => 'required|string|max:255',
            'activity_date' => 'required|date',
            'location' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'radius_meter' => 'required|integer|min:1|max:1000',
            'description' => 'nullable|string',
            'status' => 'required|in:draft,scheduled,completed,cancelled',
        ]);

        $user = auth()->user();

        if (!$user->hasRole('super_admin') && !$user->hasRole('admin_desa')) {
            $validated['organization_id'] = $user->organization_id;
        }

        $activity = Activity::create($validated);

        // Send WhatsApp Notification if status is scheduled
        if ($activity->status === 'scheduled') {
            $this->notifyMembers($activity);
        }

        return redirect()
            ->route('activities.index')
            ->with('success', 'Kegiatan berhasil dibuat.');
    }

    public function show(Activity $activity)
    {
        $activity->load('organization');

        return view('activities.show', compact('activity'));
    }

    public function edit(Activity $activity)
    {
        $user = auth()->user();

        if (
            !$user->hasRole('super_admin') &&
            !$user->hasRole('admin_desa') &&
            $activity->organization_id != $user->organization_id
        ) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        if ($user->hasRole('super_admin') || $user->hasRole('admin_desa')) {
            $organizations = Organization::orderBy('name')->get();
        } else {
            $organizations = Organization::where('id', $user->organization_id)->get();
        }

        return view('activities.edit', compact('activity', 'organizations'));
    }

    public function update(Request $request, Activity $activity)
    {
        $user = auth()->user();

        if (
            !$user->hasRole('super_admin') &&
            !$user->hasRole('admin_desa') &&
            $activity->organization_id != $user->organization_id
        ) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $validated = $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'title' => 'required|string|max:255',
            'activity_date' => 'required|date',
            'location' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'radius_meter' => 'required|integer|min:1|max:1000',
            'description' => 'nullable|string',
            'status' => 'required|in:draft,scheduled,completed,cancelled',
        ]);

        $oldStatus = $activity->status;

        if (!$user->hasRole('super_admin') && !$user->hasRole('admin_desa')) {
            $validated['organization_id'] = $user->organization_id;
        }

        $activity->update($validated);

        // Send notification if status changed to scheduled, or if still scheduled and updated
        if ($activity->status === 'scheduled') {
            $this->notifyMembers($activity);
        }

        return redirect()
            ->route('activities.index')
            ->with('success', 'Kegiatan diperbarui.');
    }

    /**
     * Helper to send broadcast notification to organization members
     */
    protected function notifyMembers(Activity $activity)
    {
        $chatbotActive = \App\Models\Setting::get('chatbot_active', 'true') === 'true';
        if (!$chatbotActive) return;

        $members = \App\Models\OrganizationMember::where('organization_id', $activity->organization_id)
            ->whereNotNull('phone')
            ->get();

        if ($members->isEmpty()) return;

        $phones = $members->pluck('phone')->toArray();
        $dateFormatted = $activity->activity_date->format('d/m/Y H:i');
        
        $message = "📢 *PENGUMUMAN KEGIATAN BARU*\n\n";

        $message .= "Halo rekan-rekan *" . ($activity->organization->name ?? 'Organisasi') . "*,\n";
        $message .= "Telah dijadwalkan kegiatan baru:\n\n";
        $message .= "📌 *Kegiatan:* " . $activity->title . "\n";
        $message .= "📅 *Tanggal:* " . $dateFormatted . "\n";
        $message .= "📍 *Lokasi:* " . ($activity->location ?? 'Segera ditentukan') . "\n";
        
        if ($activity->latitude && $activity->longitude) {
            $message .= "🗺️ *Peta:* https://www.google.com/maps/search/?api=1&query={$activity->latitude},{$activity->longitude}\n";
        }

        if ($activity->description) {
            $message .= "\n📝 *Keterangan:* " . $activity->description . "\n";
        }

        $message .= "\nMohon kehadirannya tepat waktu. Terima kasih! 🙏";

        $whatsapp = app(\App\Services\WhatsAppService::class);
        $whatsapp->sendMassMessage($phones, $message);
    }


    public function destroy(Activity $activity)
    {
        $activity->delete();

        return redirect()
            ->route('activities.index')
            ->with('success', 'Kegiatan dihapus.');
    }

    public function exportPdf(Request $request)
    {
        $user = auth()->user();

        $query = \App\Models\Activity::with([
            'organization',
            'attendances.member',
        ]);

        if (!$user->hasRole('super_admin') && !$user->hasRole('admin_desa')) {
            $query->where('organization_id', $user->organization_id);
        }

        if ($request->filled('organization_id')) {
            $query->where('organization_id', $request->organization_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('activity_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('activity_date', '<=', $request->date_to);
        }

        if ($request->filled('keyword')) {
            $query->where('title', 'like', '%' . $request->keyword . '%');
        }

        $activities = $query->latest()->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('activities.pdf', compact('activities'));

        return $pdf->download('laporan-kegiatan-lengkap.pdf');
    }

    public function exportExcel(Request $request)
    {
        $user = auth()->user();

        $query = \App\Models\Activity::with([
            'organization',
            'attendances.member'
        ]);

        if (!$user->hasRole('super_admin') && !$user->hasRole('admin_desa')) {
            $query->where('organization_id', $user->organization_id);
        }

        // filter sama seperti PDF
        if ($request->filled('organization_id')) {
            $query->where('organization_id', $request->organization_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('activity_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('activity_date', '<=', $request->date_to);
        }

        if ($request->filled('keyword')) {
            $query->where('title', 'like', '%' . $request->keyword . '%');
        }

        $activities = $query->latest()->get();

        $filename = "laporan-kegiatan-organisasi.csv";

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($activities) {

            $file = fopen('php://output', 'w');

            // BOM supaya Excel tidak rusak encoding
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Judul laporan
            fputcsv($file, ['LAPORAN KEGIATAN ORGANISASI']);
            fputcsv($file, ['Tanggal Cetak: ' . now()]);
            fputcsv($file, []);

            foreach ($activities as $activity) {

                fputcsv($file, ['KEGIATAN: ' . $activity->title]);

                fputcsv($file, ['Organisasi', $activity->organization?->name]);
                fputcsv($file, ['Tanggal', $activity->activity_date]);
                fputcsv($file, ['Status', $activity->status]);
                fputcsv($file, ['Lokasi', $activity->location]);
                fputcsv($file, ['Deskripsi', $activity->description]);

                fputcsv($file, []);

                // header absensi
                fputcsv($file, [
                    'No',
                    'Nama Anggota',
                    'Jabatan',
                    'Status Kehadiran',
                    'Keterangan'
                ]);

                $no = 1;

                if ($activity->attendances->count()) {

                    foreach ($activity->attendances as $attendance) {

                        fputcsv($file, [
                            $no++,
                            $attendance->member?->full_name,
                            $attendance->member?->position,
                            $attendance->status,
                            $attendance->notes
                        ]);
                    }

                } else {

                    fputcsv($file, ['Belum ada absensi']);
                }

                // spasi antar kegiatan
                fputcsv($file, []);
                fputcsv($file, []);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}