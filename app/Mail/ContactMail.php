<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $subject;
    public $messageContent;

    /**
     * Create a new message instance.
     */
    public function __construct($name, $email, $subject, $messageContent)
    {
        $this->name = $name;
        $this->email = $email;
        $this->subject = $subject;
        $this->messageContent = $messageContent;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: config('mail.from.address'),
            subject: 'Nouveau message de contact - ' . $this->subject,
            using: [
                function ($message) {
                    // Headers anti-spam
                    $message
                        ->getHeaders()
                        ->addTextHeader('X-Mailer', 'Laravel')
                        ->addTextHeader('X-Priority', '1 (Highest)')
                        ->addTextHeader('X-MSMail-Priority', 'High')
                        ->addTextHeader('Precedence', 'bulk');
                },
            ]
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contact_view',
            text: 'emails.contact_text',
            with: [
                'name' => $this->name,
                'email' => $this->email,
                'subject' => $this->subject,
                'messageContent' => $this->messageContent,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}