<?php
// app/Models/PopDocumentUpload.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PopDocumentUpload extends Model
{
    use HasFactory;

    protected $fillable = [
        'pop_participant_id',
        'ktp_number',
        'diploma_number',
        'scan_ktp',
        'scan_diploma',
        'cv_file',
        'work_certificate',
        'mining_experience_letter',
    ];

    public function participant()
    {
        return $this->belongsTo(PopParticipant::class, 'pop_participant_id');
    }
}