<?php
// app/Models/ReferralCode.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'description',
        'discount_amount',
        'discount_percentage',
        'is_active'
    ];

    protected $casts = [
        'discount_amount' => 'decimal:2',
        'is_active' => 'boolean',
    ];
}