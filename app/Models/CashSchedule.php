<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CashSchedule extends Model
{
    protected $fillable = [
        'cash_group_id',
        'due_date',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(CashGroup::class, 'cash_group_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(CashPayment::class);
    }
}