<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    protected $fillable = [
        'organization_id',
        'created_by',
        'title',
        'proposal_date',
        'description',
        'file_path',
        'status',
        'admin_notes',
        'target_type',
        'target_organization_id'
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function targetOrganization()
    {
        return $this->belongsTo(Organization::class, 'target_organization_id');
    }
    public function messages()
    {
        return $this->hasMany(\App\Models\ProposalMessage::class)->latest();
    }
}