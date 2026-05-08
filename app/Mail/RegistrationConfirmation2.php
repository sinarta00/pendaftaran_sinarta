<?php

namespace App\Mail;

use App\Models\Participant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationConfirmation2 extends Mailable
{
    use Queueable, SerializesModels;

    public $participant;

    public function __construct(Participant $participant)
    {
        $this->participant = $participant;
    }

    public function build()
    {
        return $this->subject('Konfirmasi Pendaftaran AK3U - Utusan Perusahaan')
                    ->view('emails.registration-confirmation2');
    }
}