<?php
// app/Models/PopPayment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PopPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'pop_participant_id',
        'invoice_number',
        'payment_type',
        'amount',
        'remaining_amount',
        'payment_date',
        'status',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
        'remaining_amount' => 'decimal:2',
    ];

    public function participant()
    {
        return $this->belongsTo(PopParticipant::class, 'pop_participant_id');
    }
}