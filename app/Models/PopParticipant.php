<?php
// app/Models/PopParticipant.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PopParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_number',
        'full_name',
        'email',
        'phone',
        'birth_place',
        'birth_date',
        'education',
        'training_schedule_id', // ✅ TAMBAHKAN INI
        'category',
        'company_name',
        'information_source',
        'referral_code',
        'agreement_checkbox',
        'status',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'agreement_checkbox' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($participant) {
            $participant->registration_number = 'POP-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        });
    }

    // Hitung harga berdasarkan kategori
    public function getPriceAttribute()
    {
        return $this->category === 'online' ? 3800000 : 4800000;
    }

    // ✅ TAMBAHKAN RELASI INI
    public function trainingSchedule()
    {
        return $this->belongsTo(TrainingSchedule::class);
    }

    public function documentUploads()
    {
        return $this->hasOne(PopDocumentUpload::class);
    }

    public function payments()
    {
        return $this->hasMany(PopPayment::class);
    }
}