<?php
namespace App\Mail\Concerns;

use App\Models\EmailAttachmentSetting;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Storage;

trait HasEmailAttachment
{
    protected function attachConfiguredFile(Mailable $mail): Mailable
    {
        $setting = EmailAttachmentSetting::where('key', static::class)->first();

        if ($setting?->attachment_path && Storage::disk('public')->exists($setting->attachment_path)) {
            $mail->attachFromStorageDisk(
                'public',
                $setting->attachment_path,
                $setting->attachment_name ?: basename($setting->attachment_path)
            );
        }

        return $mail;
    }
}

