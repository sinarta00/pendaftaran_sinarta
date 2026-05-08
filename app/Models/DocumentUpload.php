<?php
// app/Models/DocumentUpload.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentUpload extends Model
{
    use HasFactory;

    protected $fillable = [
        'participant_id',
        'ktp_number',
        'diploma_number',
        'scan_diploma',
        'scan_ktp',
        'scan_photo',
        'health_certificate',
        'cv_file',
        'integrity_pact',
        'work_certificate',
        'company_npwp'
    ];

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }
}