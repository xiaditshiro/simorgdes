<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\ProposalMessage;
use Illuminate\Http\Request;

class ProposalMessageController extends Controller
{
    public function store(Request $request, Proposal $proposal)
    {
        $user = auth()->user();

        if ($user->hasRole('super_admin')) {
            // boleh
        } elseif ($user->hasRole('admin_desa')) {
            if ($proposal->target_type !== 'desa') {
                abort(403, 'Anda tidak memiliki akses ke diskusi proposal ini.');
            }
        } else {
            $allowed = $proposal->organization_id == $user->organization_id
                || $proposal->target_organization_id == $user->organization_id;

            if (!$allowed) {
                abort(403, 'Anda tidak memiliki akses ke diskusi proposal ini.');
            }
        }

        $validated = $request->validate([
            'message' => 'required|string',
        ]);

        ProposalMessage::create([
            'proposal_id' => $proposal->id,
            'user_id' => $user->id,
            'message' => $validated['message'],
        ]);

        return back()->with('success', 'Pesan berhasil dikirim.');
    }
}