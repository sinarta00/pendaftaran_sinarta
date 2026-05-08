<?php
// app/Mail/SkpPaymentConfirmation.php

namespace App\Mail;

use App\Models\SkpRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SkpPaymentConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $registration;

    public function __construct(SkpRegistration $registration)
    {
        $this->registration = $registration;
    }

    public function build()
    {
        return $this->view('emails.skp-payment-confirmation')
                    ->subject('Konfirmasi Pembayaran SKP - ' . $this->registration->registration_number);
    }
}