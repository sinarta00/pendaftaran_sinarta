<?php
// app/Mail/PopRegistrationConfirmation.php

namespace App\Mail;

use App\Models\PopParticipant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PopRegistrationConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $participant;

    public function __construct(PopParticipant $participant)
    {
        $this->participant = $participant;
    }

    public function build()
    {
        return $this->subject('Konfirmasi Pendaftaran POP BNSP')
                    ->view('emails.pop-registration-confirmation');
    }
}