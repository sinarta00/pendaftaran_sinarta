<?php
// app/Models/Participant.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

 protected $fillable = [
    'registration_number',
    'type',
    'full_name',
    'email',
    'phone',
    'birth_place',
    'birth_date',
    'gender',             
    'domisili_kota',      
    'jurusan',            
    'institution_name',   
    'employment_status',  
    'work_company_name',  
    'training_purpose',    
    'education',
    'education_bnsp',
    'training_schedule_id',
    'shirt_size',
    'participant_category',
    'company_name',
    'company_address',
    'company_phone',
    'information_source',
    'referral_code',
    'status',
    'invoice_file',
    'golongan_darah'
];

    protected $casts = [
        'birth_date' => 'date',
        'agreement_checkbox' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($participant) {
            $participant->registration_number = 'AK3U-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        });
    }

    public function trainingSchedule()
    {
        return $this->belongsTo(TrainingSchedule::class);
    }

    public function documentUploads()
    {
        return $this->hasOne(DocumentUpload::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}