<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerificationCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $code; 

    public function __construct(int $code)
    {
        $this->code = $code; 
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'YOUR VERIFICATION CODE', 
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.verification_code', 
        );
    }
}