<?php
// app/Mail/PaymentComplete.php

namespace App\Mail;

use App\Models\Participant;
use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentComplete extends Mailable
{
    use Queueable, SerializesModels;

    public $participant;
    public $payment;

    public function __construct(Participant $participant, Payment $payment)
    {
        $this->participant = $participant;
        $this->payment = $payment;
    }

    public function build()
    {
        return $this->view('emails.payment-complete')
                    ->subject('Pembayaran Lunas - ' . $this->participant->registration_number);
    }
}