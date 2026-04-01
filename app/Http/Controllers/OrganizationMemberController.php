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
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('super_admin') || $user->hasRole('admin_desa')) {
            $members = OrganizationMember::with('organization')
                ->latest()
                ->get();
        } else {
            $members = OrganizationMember::with('organization')
                ->where('organization_id', $user->organization_id)
                ->latest()
                ->get();
        }

        return view('members.index', compact('members'));
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

        OrganizationMember::create($validated);

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