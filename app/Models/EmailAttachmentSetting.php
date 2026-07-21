<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailAttachmentSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'label',
        'attachment_path',
        'attachment_name',
    ];
}
