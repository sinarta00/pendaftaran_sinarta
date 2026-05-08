<?php

namespace App\Mail;

use App\Models\Participant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class InvoiceSent extends Mailable
{
    use Queueable, SerializesModels;

    public $participant;

    public function __construct(Participant $participant)
    {
        $this->participant = $participant;
    }

    public function build()
    {
        $email = $this->subject('Pendaftaran Berhasil - Invoice AK3U')
                      ->view('emails.invoice-sent');
        
        // Attach invoice jika ada
        if ($this->participant->invoice_file) {
            $email->attach(Storage::disk('public')->path($this->participant->invoice_file), [
                'as' => 'Invoice_' . $this->participant->registration_number . '.pdf',
                'mime' => 'application/pdf',
            ]);
        }
        
        return $email;
    }
}