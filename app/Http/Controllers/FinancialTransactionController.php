<?php

namespace App\Http\Controllers;

use App\Models\FinancialTransaction;
use App\Models\Organization;
use Illuminate\Http\Request;

class FinancialTransactionController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $query = FinancialTransaction::with([
            'organization',
            'creator',
            'cashPayment.member'
        ])->latest('transaction_date');

        if (!$user->hasRole('super_admin') && !$user->hasRole('admin_desa')) {
            $query->where('organization_id', $user->organization_id);
        }

        $transactions = $query->get();

        $totalIncome = (clone $query)->where('type', 'income')->sum('amount');
        $totalExpense = (clone $query)->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        return view('finance.index', compact('transactions', 'totalIncome', 'totalExpense', 'balance'));
    }

    public function create()
    {
        $user = auth()->user();

        if ($user->hasRole('super_admin') || $user->hasRole('admin_desa')) {
            $organizations = Organization::orderBy('name')->get();
        } else {
            $organizations = Organization::where('id', $user->organization_id)->get();
        }

        $categories = \App\Models\FinancialCategory::where('organization_id', $user->organization_id)
            ->orderBy('name')
            ->get();

        return view('finance.create', compact('organizations', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'transaction_date' => 'required|date',
            'type' => 'required|in:income,expense',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:1',
        ]);

        $user = auth()->user();

        if (!$user->hasRole('super_admin') && !$user->hasRole('admin_desa')) {
            $validated['organization_id'] = $user->organization_id;
        }

        $validated['source'] = 'manual';
        $validated['created_by'] = $user->id;

        FinancialTransaction::create($validated);

        return redirect()->route('finance.index')
            ->with('success', 'Transaksi keuangan berhasil ditambahkan.');
    }

    public function edit(FinancialTransaction $finance)
    {


        $user = auth()->user();

        if (
            !$user->hasRole('super_admin') &&
            !$user->hasRole('admin_desa') &&
            $finance->organization_id != $user->organization_id
        ) {
            abort(403);
        }

        $organizations = $user->hasRole('super_admin') || $user->hasRole('admin_desa')
            ? Organization::orderBy('name')->get()
            : Organization::where('id', $user->organization_id)->get();

        $categories = \App\Models\FinancialCategory::where('organization_id', $finance->organization_id)
            ->orderBy('name')
            ->get();

        return view('finance.edit', compact('finance', 'organizations', 'categories'));
    }

    public function update(Request $request, FinancialTransaction $finance)
    {


        $user = auth()->user();

        if (
            !$user->hasRole('super_admin') &&
            !$user->hasRole('admin_desa') &&
            $finance->organization_id != $user->organization_id
        ) {
            abort(403);
        }

        $validated = $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'transaction_date' => 'required|date',
            'type' => 'required|in:income,expense',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:1',
        ]);

        if (!$user->hasRole('super_admin') && !$user->hasRole('admin_desa')) {
            $validated['organization_id'] = $user->organization_id;
        }

        $finance->update($validated);

        return redirect()->route('finance.index')
            ->with('success', 'Transaksi keuangan berhasil diperbarui.');
    }

    public function destroy(FinancialTransaction $finance)
    {

        $user = auth()->user();

        if (
            !$user->hasRole('super_admin') &&
            !$user->hasRole('admin_desa') &&
            $finance->organization_id != $user->organization_id
        ) {
            abort(403);
        }

        $finance->delete();

        return redirect()->route('finance.index')
            ->with('success', 'Transaksi keuangan berhasil dihapus.');
    }
}