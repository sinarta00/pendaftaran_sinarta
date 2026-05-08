<?php
// app/Mail/TotPaymentConfirmation.php

namespace App\Mail;

use App\Models\TotRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TotPaymentConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $registration;

    public function __construct(TotRegistration $registration)
    {
        $this->registration = $registration;
    }

    public function build()
    {
        return $this->view('emails.tot-payment-confirmation')
                    ->subject('Konfirmasi Pembayaran TOT - ' . $this->registration->registration_number);
    }
}