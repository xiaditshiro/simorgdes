<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CashPayment extends Model
{
    protected $fillable = [
        'cash_schedule_id',
        'member_id',
        'status',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(CashSchedule::class, 'cash_schedule_id');
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(OrganizationMember::class, 'member_id');
    }
    public function financialTransaction()
    {
        return $this->hasOne(FinancialTransaction::class);
    }
}