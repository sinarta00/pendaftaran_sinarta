<?php

namespace App\Mail;

use App\Models\Ak3uBnspRenewal;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Ak3uBnspRenewalPaymentConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $registration;

    public function __construct(Ak3uBnspRenewal $registration)
    {
        $this->registration = $registration;
    }

    public function build()
    {
        return $this->view('emails.ak3u-bnsp-renewal-payment-confirmation')
                    ->subject('Konfirmasi Pembayaran Perpanjangan AK3U BNSP - ' . $this->registration->registration_number);
    }
}
