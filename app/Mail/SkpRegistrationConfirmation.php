<?php
// app/Mail/SkpRegistrationConfirmation.php

namespace App\Mail;

use App\Models\SkpRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SkpRegistrationConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $registration;

    public function __construct(SkpRegistration $registration)
    {
        $this->registration = $registration;
    }

    public function build()
    {
        return $this->view('emails.skp-registration-confirmation')
                    ->subject('Pendaftaran SKP Diterima - ' . $this->registration->registration_number);
    }
}