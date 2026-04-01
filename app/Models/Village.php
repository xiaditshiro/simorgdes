<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Village extends Model
{
    protected $fillable = [
        'name',
        'district',
        'regency',
        'province',
        'address',
        'postal_code',
        'phone',
        'email',
    ];

    public function organizations(): HasMany
    {
        return $this->hasMany(Organization::class);
    }
}