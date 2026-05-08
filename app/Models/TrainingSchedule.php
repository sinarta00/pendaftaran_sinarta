<?php
// app/Models/TrainingSchedule.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'location',
        'type',
        'price',
        'max_participants',
        'is_active',
        'golongan_darah'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

    // ✅ TAMBAHKAN RELASI INI
    public function popParticipants()
    {
        return $this->hasMany(PopParticipant::class);
    }
}