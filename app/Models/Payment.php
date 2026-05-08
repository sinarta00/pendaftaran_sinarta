<?php
// app/Models/Payment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'participant_id',
        'invoice_number',
        'payment_type',
        'amount',
        'remaining_amount',
        'payment_date',
        'status'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'remaining_amount' => 'decimal:2',
        'payment_date' => 'date',
    ];

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }
}