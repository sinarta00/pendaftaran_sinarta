<?php
// app/Models/SkpRegistration.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkpRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_number',
        'full_name',
        'phone',
        'email',
        'nik',
        'diploma_number',
        'gender',
        'blood_type',
        'education',
        'type',
        'company_name',
        'company_address',
        'old_sk_number',
        'old_license_number',
        'ktp_file',
        'work_certificate',
        'diploma_file',
        'ak3u_certificate',
        'photo_file',
        'full_work_certificate',
        'status',
        'invoice_number',
        'payment_date',
        'total_payment'
    ];

    protected $casts = [
        'payment_date' => 'date',
        'total_payment' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($registration) {
            $registration->registration_number = 'SKP-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        });
    }
}