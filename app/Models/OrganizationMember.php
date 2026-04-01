<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrganizationMember extends Model
{
    protected $fillable = [
        'organization_id',
        'user_id',
        'full_name',
        'nik',
        'gender',
        'birth_place',
        'birth_date',
        'address',
        'phone',
        'position',
        'join_date',
        'status',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'join_date' => 'date',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
    public function attendances(): HasMany
    {
        return $this->hasMany(ActivityAttendance::class, 'member_id');
    }
    public function cashPayments()
    {
        return $this->hasMany(CashPayment::class, 'member_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }


}