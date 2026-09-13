<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ak3uBnspRenewal extends Model
{
    use HasFactory;

    protected $table = 'ak3u_bnsp_renewals';

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
        'company_application_later',
        'skp__later',
        'license_later',
        'activity_report_later',
        'status',
        'invoice_number',
        'payment_date',
        'total_payment',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'total_payment' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($renewal) {
            if (empty($renewal->registration_number)) {
                $renewal->registration_number = 'BNSP-EXT-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            }
        });
    }
}
