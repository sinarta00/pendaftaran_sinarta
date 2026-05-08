<?php
// app/Models/TotRegistration.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class TotRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_number',
        'full_name',
        'email',
        'phone',
        'nik',
        'diploma_number',
        'birth_place',
        'birth_date',
        'education',
        'level',
        'information_source',
        'referral_code',
        'agreement_checkbox',
        'photo_file',
        'ktp_file',
        'diploma_file',
        'tot_assistant_cert',
        'tot_instructor_cert',
        'kkni_level4_cert',
        'work_exp_assistant',
        'work_exp_instructor',
        'work_exp_senior',
        'senior_instructor_cert',
        'master_instructor_cert',
        'status',
        'invoice_number',
        'payment_date',
        'total_payment'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'payment_date' => 'date',
        'agreement_checkbox' => 'boolean',
        'total_payment' => 'decimal:2',
    ];

   protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($registration) {
            $registration->registration_number = 'TOT-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        });
    
        // ✅ TAMBAH INI
        static::deleting(function ($registration) {
            $fileColumns = [
                'photo_file',
                'ktp_file',
                'diploma_file',
                'tot_assistant_cert',
                'tot_instructor_cert',
                'kkni_level4_cert',
                'work_exp_assistant',
                'work_exp_instructor',
                'work_exp_senior',
                'senior_instructor_cert',
                'master_instructor_cert',
            ];
    
            foreach ($fileColumns as $column) {
                if ($registration->$column) {
                    Storage::disk('public')->delete($registration->$column);
                }
            }
        });
    }
}