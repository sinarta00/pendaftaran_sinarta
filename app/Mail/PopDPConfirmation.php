<?php
// app/Mail/PopDPConfirmation.php

namespace App\Mail;

use App\Models\PopParticipant;
use App\Models\PopPayment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PopDPConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $participant;
    public $payment;

    public function __construct(PopParticipant $participant, PopPayment $payment)
    {
        $this->participant = $participant;
        $this->payment = $payment;
    }

    public function build()
    {
        return $this->subject('Konfirmasi Pembayaran DP - POP BNSP')
                    ->view('emails.pop-dp-confirmation');
    }
}