<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    protected $fillable = [
        'village_id',
        'name',
        'type',
        'established_date',
        'address',
        'phone',
        'email',
        'leader_name',
        'secretary_name',
        'treasurer_name',
        'logo',
        'legal_doc',
        'status',
    ];

    protected $casts = [
        'established_date' => 'date',
    ];

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    public function members(): HasMany
    {
        return $this->hasMany(OrganizationMember::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
    public function cashSchedules()
    {
        return $this->hasMany(CashSchedule::class);
    }
    public function cashGroups()
    {
        return $this->hasMany(\App\Models\CashGroup::class);
    }
}