<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\Organization;
use Illuminate\Http\Request;

class ProposalController extends Controller
{

    public function index()
    {
        $user = auth()->user();

        $query = Proposal::with([
            'organization',
            'creator',
            'targetOrganization'
        ])->latest();

        if ($user->hasRole('super_admin')) {
            // super admin lihat semua
        } elseif ($user->hasRole('admin_desa')) {
            // admin desa hanya lihat proposal yang dikirim ke desa
            $query->where('target_type', 'desa');
        } else {
            // organisasi lihat proposal yang dikirim olehnya
            // atau proposal yang ditujukan kepadanya
            $query->where(function ($q) use ($user) {
                $q->where('organization_id', $user->organization_id)
                    ->orWhere('target_organization_id', $user->organization_id);
            });
        }

        $proposals = $query->get();

        return view('proposals.index', compact('proposals'));
    }

    public function create()
    {
        $user = auth()->user();

        if ($user->hasRole('super_admin') || $user->hasRole('admin_desa')) {
            $senderOrganizations = Organization::orderBy('name')->get();
            $targetOrganizations = Organization::orderBy('name')->get();
        } else {
            $senderOrganizations = Organization::where('id', $user->organization_id)->get();

            $targetOrganizations = Organization::where('id', '!=', $user->organization_id)
                ->orderBy('name')
                ->get();
        }

        return view('proposals.create', compact('senderOrganizations', 'targetOrganizations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'title' => 'required|string|max:255',
            'proposal_date' => 'required|date',
            'description' => 'nullable|string',
            'file' => 'nullable|file',
            'target_type' => 'required|in:desa,organization',
            'target_organization_id' => 'nullable|exists:organizations,id'
        ]);

        if ($request->file('file')) {
            $validated['file_path'] = $request->file('file')->store('proposals', 'public');
        }

        $validated['created_by'] = auth()->id();

        Proposal::create($validated);

        return redirect()->route('proposals.index')
            ->with('success', 'Proposal berhasil dibuat');
    }

    public function show(Proposal $proposal)
    {
        $user = auth()->user();

        if ($user->hasRole('super_admin')) {
            $proposal->load(['organization', 'creator', 'targetOrganization', 'messages.user']);
            return view('proposals.show', compact('proposal'));
        }

        if ($user->hasRole('admin_desa')) {
            if ($proposal->target_type !== 'desa') {
                abort(403, 'Anda tidak memiliki akses ke proposal ini.');
            }

            $proposal->load(['organization', 'creator', 'targetOrganization', 'messages.user']);
            return view('proposals.show', compact('proposal'));
        }

        if (
            $proposal->organization_id != $user->organization_id &&
            $proposal->target_organization_id != $user->organization_id
        ) {
            abort(403, 'Anda tidak memiliki akses ke proposal ini.');
        }

        $proposal->load(['organization', 'creator', 'targetOrganization', 'messages.user']);

        return view('proposals.show', compact('proposal'));
    }

    public function approve(Proposal $proposal)
    {
        $proposal->update([
            'status' => 'approved'
        ]);

        return back()->with('success', 'Proposal disetujui');
    }

    public function reject(Request $request, Proposal $proposal)
    {
        $proposal->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes
        ]);

        return back()->with('success', 'Proposal ditolak');
    }

    public function edit(Proposal $proposal)
    {
        $user = auth()->user();

        // hanya pengirim proposal yang boleh edit
        if ($proposal->organization_id != $user->organization_id) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit proposal ini.');
        }

        // tidak boleh edit jika sudah diproses
        if ($proposal->status != 'pending') {
            return back()->with('error', 'Proposal tidak bisa diedit karena sudah diproses.');
        }

        $organizations = Organization::where('id', $user->organization_id)->get();

        return view('proposals.edit', compact('proposal', 'organizations'));
    }
    public function update(Request $request, Proposal $proposal)
    {
        $user = auth()->user();

        // hanya pengirim proposal yang boleh update
        if ($proposal->organization_id != $user->organization_id) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah proposal ini.');
        }

        if ($proposal->status != 'pending') {
            return back()->with('error', 'Proposal tidak bisa diubah karena sudah diproses.');
        }

        $validated = $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'title' => 'required|string|max:255',
            'proposal_date' => 'required|date',
            'description' => 'nullable|string',
            'target_type' => 'required|in:desa,organization',
            'target_organization_id' => 'nullable|exists:organizations,id',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $validated['organization_id'] = $user->organization_id;

        if (
            $request->target_type === 'organization' &&
            $request->target_organization_id == $validated['organization_id']
        ) {
            return back()
                ->withErrors(['target_organization_id' => 'Tujuan proposal tidak boleh organisasi sendiri.'])
                ->withInput();
        }

        if ($request->file('file')) {
            if ($proposal->file_path) {
                \Storage::disk('public')->delete($proposal->file_path);
            }

            $validated['file_path'] = $request->file('file')->store('proposals', 'public');
        }

        $proposal->update($validated);

        return redirect()->route('proposals.index')
            ->with('success', 'Proposal berhasil diperbarui');
    }
    public function destroy(Proposal $proposal)
    {
        $user = auth()->user();

        if ($proposal->organization_id != $user->organization_id) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus proposal ini.');
        }

        if ($proposal->status != 'pending') {
            return back()->with('error', 'Proposal tidak bisa dihapus karena sudah diproses.');
        }

        if ($proposal->file_path) {
            \Storage::disk('public')->delete($proposal->file_path);
        }

        $proposal->delete();

        return redirect()->route('proposals.index')
            ->with('success', 'Proposal berhasil dihapus');
    }

    public function inbox()
    {
        $user = auth()->user();

        $query = Proposal::with(['organization', 'creator', 'targetOrganization'])->latest();

        if ($user->hasRole('super_admin')) {
            // lihat semua
        } elseif ($user->hasRole('admin_desa')) {
            $query->where('target_type', 'desa');
        } else {
            $query->where('target_organization_id', $user->organization_id);
        }

        $proposals = $query->get();

        return view('proposals.inbox', compact('proposals'));
    }

    public function sent()
    {
        $user = auth()->user();

        $query = Proposal::with(['organization', 'creator', 'targetOrganization'])->latest();

        if (!$user->hasRole('super_admin')) {
            $query->where('organization_id', $user->organization_id);
        }

        $proposals = $query->get();

        return view('proposals.sent', compact('proposals'));
    }



}