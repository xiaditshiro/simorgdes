<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Organization;
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

        $activities = $query->latest()->get();

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
            'description' => 'nullable|string',
            'status' => 'required|in:draft,scheduled,completed,cancelled',
        ]);

        $user = auth()->user();

        if (!$user->hasRole('super_admin') && !$user->hasRole('admin_desa')) {
            $validated['organization_id'] = $user->organization_id;
        }

        Activity::create($validated);

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
            'description' => 'nullable|string',
            'status' => 'required|in:draft,scheduled,completed,cancelled',
        ]);

        if (!$user->hasRole('super_admin') && !$user->hasRole('admin_desa')) {
            $validated['organization_id'] = $user->organization_id;
        }

        $activity->update($validated);

        return redirect()
            ->route('activities.index')
            ->with('success', 'Kegiatan diperbarui.');
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