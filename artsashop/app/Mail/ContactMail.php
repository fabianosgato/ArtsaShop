<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data; // Variável pública para acessar na View

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function envelope(): Envelope
    {

        return new Envelope(
            from: new Address('fabianogattoti@gmail.com', 'ArtisaShop'),
            replyTo: [
                new Address(
                    $this->data['email_address'],
                    $this->data['contact_name']
                ),
            ],
            subject: 'Novo Contato do Site: ' . $this->data['subject_contacts'],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.contact-mail', // Caminho da View que vamos criar
        );
    }

}
