<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\OrganizationMember;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class OrganizationMemberController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = OrganizationMember::with('organization');

        if (!$user->hasRole('super_admin') && !$user->hasRole('admin_desa')) {
            $query->where('organization_id', $user->organization_id);
        } else {
            $organizations = \App\Models\Organization::orderBy('name')->get();
            if ($request->filled('organization_id')) {
                $query->where('organization_id', $request->organization_id);
            }
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $search = $request->search;
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('position')) {
            $query->where('position', $request->position);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->get('export') == 'csv') {
            return $this->exportCsv($query->latest()->get());
        }

        $members = $query->latest()->paginate(10);
        
        $viewData = compact('members');
        if (isset($organizations)) {
            $viewData['organizations'] = $organizations;
        }

        return view('members.index', $viewData);
    }

    private function exportCsv($members)
    {
        $fileName = 'data_anggota_' . date('Ymd_His') . '.csv';

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'No', 'Nama Lengkap', 'NIK', 'Jenis Kelamin', 'Tempat Lahir', 'Tanggal Lahir', 'Alamat', 'No HP', 'Organisasi', 'Jabatan', 'Tanggal Bergabung', 'Status'
        ];

        $callback = function() use($members, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            
            $no = 1;
            foreach ($members as $member) {
                $row = [
                    $no++,
                    $member->full_name,
                    $member->nik ? "'" . $member->nik : '-',
                    $member->gender === 'L' ? 'Laki-laki' : ($member->gender === 'P' ? 'Perempuan' : '-'),
                    $member->birth_place ?? '-',
                    $member->birth_date ? $member->birth_date->format('d-m-Y') : '-',
                    $member->address ?? '-',
                    $member->phone ? "'" . $member->phone : '-',
                    $member->organization?->name ?? '-',
                    ucfirst($member->position),
                    $member->join_date ? $member->join_date->format('d-m-Y') : '-',
                    ucfirst($member->status)
                ];
                fputcsv($file, $row);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function create()
    {
        $user = auth()->user();

        if ($user->hasRole('super_admin') || $user->hasRole('admin_desa')) {
            $organizations = \App\Models\Organization::orderBy('name')->get();
        } else {
            $organizations = \App\Models\Organization::where('id', $user->organization_id)->get();
        }

        return view('members.create', compact('organizations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'full_name' => 'required|string|max:255',
            'nik' => 'nullable|string|max:20',
            'gender' => 'nullable|in:L,P',
            'birth_place' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'position' => 'required|in:ketua,sekretaris,bendahara,anggota',
            'join_date' => 'nullable|date',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        if (
            !auth()->user()->hasRole('super_admin') &&
            !auth()->user()->hasRole('admin_desa')
        ) {
            $validated['organization_id'] = auth()->user()->organization_id;
        }

        $member = OrganizationMember::create($validated);

        // Backfill existing cash schedules for this organization starting from join date
        try {
            $joinDate = $member->join_date ?? now();
            
            $schedules = \App\Models\CashSchedule::whereHas('group', function($query) use ($member) {
                $query->where('organization_id', $member->organization_id);
            })
            ->where('due_date', '>=', $joinDate)
            ->get();

            foreach ($schedules as $schedule) {
                \App\Models\CashPayment::firstOrCreate([
                    'cash_schedule_id' => $schedule->id,
                    'member_id' => $member->id,
                ], [
                    'status' => 'unpaid',
                ]);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Failed to backfill cash payments for new member: " . $e->getMessage());
        }

        return redirect()
            ->route('members.index')
            ->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function show(OrganizationMember $member)
    {
        $user = auth()->user();

        if (
            !$user->hasRole('super_admin') &&
            !$user->hasRole('admin_desa') &&
            $member->organization_id != $user->organization_id
        ) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        return view('members.show', compact('member'));
    }

    public function edit(OrganizationMember $member)
    {
        $user = auth()->user();

        if (
            !$user->hasRole('super_admin') &&
            !$user->hasRole('admin_desa') &&
            $member->organization_id != $user->organization_id
        ) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        if ($user->hasRole('super_admin') || $user->hasRole('admin_desa')) {
            $organizations = \App\Models\Organization::orderBy('name')->get();
        } else {
            $organizations = \App\Models\Organization::where('id', $user->organization_id)->get();
        }

        return view('members.edit', compact('member', 'organizations'));
    }

    public function update(Request $request, OrganizationMember $member)
    {
        $user = auth()->user();

        if (
            !$user->hasRole('super_admin') &&
            !$user->hasRole('admin_desa') &&
            $member->organization_id != $user->organization_id
        ) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $validated = $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'full_name' => 'required|string|max:255',
            'nik' => 'required|string|max:30',
            'gender' => 'required|in:L,P',
            'birth_place' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'position' => 'required|in:ketua,sekretaris,bendahara,anggota',
            'join_date' => 'nullable|date',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        if (
            !$user->hasRole('super_admin') &&
            !$user->hasRole('admin_desa')
        ) {
            $validated['organization_id'] = $user->organization_id;
        }

        $member->update($validated);

        if ($member->user_id && $member->user) {
            $positionToRole = [
                'ketua' => 'ketua',
                'sekretaris' => 'sekretaris',
                'bendahara' => 'bendahara',
                'anggota' => 'anggota',
            ];

            $roleName = $positionToRole[$member->position] ?? 'anggota';
            $role = Role::where('name', $roleName)->first();

            if ($role) {
                $member->user->update([
                    'name' => $member->full_name,
                    'role_id' => $role->id,
                    'organization_id' => $member->organization_id,
                ]);
            }
        }

        return redirect()->route('members.index')
            ->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(OrganizationMember $member)
    {
        $user = auth()->user();

        if (
            !$user->hasRole('super_admin') &&
            !$user->hasRole('admin_desa') &&
            $member->organization_id != $user->organization_id
        ) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        // Delete associated user if exists
        if ($member->user_id) {
            \App\Models\User::where('id', $member->user_id)->delete();
        }

        $member->delete();

        return redirect()->route('members.index')
            ->with('success', 'Data anggota berhasil dihapus.');
    }
    public function createUser(OrganizationMember $member)
    {
        if ($member->user_id) {
            return back()->with('error', 'Anggota ini sudah memiliki akun user.');
        }

        $positionToRole = [
            'ketua' => 'ketua',
            'sekretaris' => 'sekretaris',
            'bendahara' => 'bendahara',
            'anggota' => 'anggota',
        ];

        $roleName = $positionToRole[$member->position] ?? 'anggota';

        $role = \App\Models\Role::where('name', $roleName)->first();

        if (!$role) {
            return back()->with('error', 'Role tidak ditemukan.');
        }

        $baseEmail = \Illuminate\Support\Str::slug($member->full_name, '') . '@simorgdes.local';
        $email = $baseEmail;
        $counter = 1;

        while (\App\Models\User::where('email', $email)->exists()) {
            $email = \Illuminate\Support\Str::slug($member->full_name, '') . $counter . '@simorgdes.local';
            $counter++;
        }

        $user = \App\Models\User::create([
            'name' => $member->full_name,
            'email' => $email,
            'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
            'role_id' => $role->id,
            'organization_id' => $member->organization_id,
            'is_active' => true,
        ]);

        $member->update([
            'user_id' => $user->id,
        ]);

        return back()->with(
            'success',
            'Akun user berhasil dibuat. Email: ' . $email . ' | Password default: 12345678'
        );
    }
}