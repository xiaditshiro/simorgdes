<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $query = User::with(['role', 'organization'])->latest();

        if (!$user->hasRole('super_admin') && !$user->hasRole('admin_desa')) {
            $query->where('organization_id', $user->organization_id);
        }

        $users = $query->get();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::orderBy('display_name')->get();
        $organizations = Organization::orderBy('name')->get();

        return view('users.create', compact('roles', 'organizations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id',
            'organization_id' => 'nullable|exists:organizations,id',
            'is_active' => 'nullable|boolean',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $validated['role_id'],
            'organization_id' => $validated['organization_id'] ?? null,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $roles = Role::orderBy('display_name')->get();
        $organizations = Organization::orderBy('name')->get();

        return view('users.edit', compact('user', 'roles', 'organizations'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'role_id' => 'required|exists:roles,id',
            'organization_id' => 'nullable|exists:organizations,id',
            'is_active' => 'nullable|boolean',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role_id' => $validated['role_id'],
            'organization_id' => $validated['organization_id'] ?? null,
            'is_active' => $request->has('is_active'),
        ];

        if (!empty($validated['password'])) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($validated['password']);
        }

        $user->update($data);

        // Sinkronkan role user ke jabatan anggota
        $role = \App\Models\Role::find($validated['role_id']);

        if ($user->organizationMember && $role) {
            $positionMap = [
                'ketua' => 'ketua',
                'sekretaris' => 'sekretaris',
                'bendahara' => 'bendahara',
                'anggota' => 'anggota',
            ];

            if (isset($positionMap[$role->name])) {
                $user->organizationMember->update([
                    'position' => $positionMap[$role->name],
                    'organization_id' => $validated['organization_id'] ?? $user->organizationMember->organization_id,
                ]);
            }
        }

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}