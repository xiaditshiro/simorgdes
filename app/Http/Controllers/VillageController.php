<?php

namespace App\Http\Controllers;

use App\Models\Village;
use Illuminate\Http\Request;

class VillageController extends Controller
{
    public function index()
    {
        $villages = Village::latest()->get();

        return view('villages.index', compact('villages'));
    }

    public function create()
    {
        return view('villages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'district' => 'nullable|string|max:255',
            'regency' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'postal_code' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        Village::create($validated);

        return redirect()
            ->route('villages.index')
            ->with('success', 'Data desa berhasil ditambahkan.');
    }

    public function show(Village $village)
    {
        return view('villages.show', compact('village'));
    }

    public function edit(Village $village)
    {
        return view('villages.edit', compact('village'));
    }

    public function update(Request $request, Village $village)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'district' => 'nullable|string|max:255',
            'regency' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'postal_code' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        $village->update($validated);

        return redirect()
            ->route('villages.index')
            ->with('success', 'Data desa berhasil diperbarui.');
    }

    public function destroy(Village $village)
    {
        $village->delete();

        return redirect()
            ->route('villages.index')
            ->with('success', 'Data desa berhasil dihapus.');
    }
}