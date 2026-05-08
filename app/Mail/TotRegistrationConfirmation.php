<?php
// app/Mail/TotRegistrationConfirmation.php

namespace App\Mail;

use App\Models\TotRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TotRegistrationConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $registration;

    public function __construct(TotRegistration $registration)
    {
        $this->registration = $registration;
    }

    public function build()
    {
        return $this->view('emails.tot-registration-confirmation')
                    ->subject('Pendaftaran TOT Diterima - ' . $this->registration->registration_number);
    }
}