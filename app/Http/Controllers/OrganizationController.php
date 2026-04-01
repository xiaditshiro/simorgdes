<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Village;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('super_admin') || $user->hasRole('admin_desa')) {
            $organizations = Organization::with('village')
                ->latest()
                ->get();
        } else {
            $organizations = Organization::with('village')
                ->where('id', $user->organization_id)
                ->latest()
                ->get();
        }

        return view('organizations.index', compact('organizations'));
    }
    public function create()
    {
        $villages = Village::orderBy('name')->get();

        return view('organizations.create', compact('villages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'village_id' => 'required|exists:villages,id',
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'established_date' => 'nullable|date',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'leader_name' => 'nullable|string|max:255',
            'secretary_name' => 'nullable|string|max:255',
            'treasurer_name' => 'nullable|string|max:255',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        Organization::create($validated);

        return redirect()
            ->route('organizations.index')
            ->with('success', 'Data organisasi berhasil ditambahkan.');
    }

    public function show(Organization $organization)
    {
        $organization->load('village');

        return view('organizations.show', compact('organization'));
    }

    public function edit(Organization $organization)
    {
        $villages = Village::orderBy('name')->get();

        return view('organizations.edit', compact('organization', 'villages'));
    }

    public function update(Request $request, Organization $organization)
    {
        $validated = $request->validate([
            'village_id' => 'required|exists:villages,id',
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'established_date' => 'nullable|date',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'leader_name' => 'nullable|string|max:255',
            'secretary_name' => 'nullable|string|max:255',
            'treasurer_name' => 'nullable|string|max:255',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $organization->update($validated);

        return redirect()
            ->route('organizations.index')
            ->with('success', 'Data organisasi berhasil diperbarui.');
    }

    public function destroy(Organization $organization)
    {
        $organization->delete();

        return redirect()
            ->route('organizations.index')
            ->with('success', 'Data organisasi berhasil dihapus.');
    }
}