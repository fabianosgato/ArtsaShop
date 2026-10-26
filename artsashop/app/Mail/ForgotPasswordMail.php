<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $link;
    public $from;

    public function __construct($data, $link)
    {
        $this->data = $data;
        $this->link = $link;
        $this->from = config('app.url');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(
                address: $this->from['address'],
                name: $this->from['name']
            ),
            subject: 'Troca de senha',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.forgot-password-mail'
        );
    }
}
