<?php

namespace App\Http\Controllers;

use App\Models\FinancialCategory;
use Illuminate\Http\Request;

class FinancialCategoryController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $categories = FinancialCategory::where('organization_id', $user->organization_id)
            ->orderBy('name')
            ->get();

        return view('finance.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
        ]);

        FinancialCategory::create([
            'organization_id' => auth()->user()->organization_id,
            'name' => $request->name,
            'type' => $request->type,
        ]);

        return back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function destroy(FinancialCategory $category)
    {
        if ($category->organization_id != auth()->user()->organization_id) {
            abort(403, 'Anda tidak memiliki akses ke kategori ini.');
        }

        $category->delete();

        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}