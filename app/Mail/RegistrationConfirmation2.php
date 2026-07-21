<?php

namespace App\Mail;

use App\Models\Participant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Mail\Concerns\HasEmailAttachment;


class RegistrationConfirmation2 extends Mailable
{
    use Queueable, SerializesModels, HasEmailAttachment;

    public $participant;

    public function __construct(Participant $participant)
    {
        $this->participant = $participant;
    }

    public function build()
    {
        $mail = $this->view('emails.registration-confirmation2')
                    ->subject('Konfirmasi Pendaftaran AK3U - Utusan Perusahaan');
        return $this->attachConfiguredFile($mail);
    }
}