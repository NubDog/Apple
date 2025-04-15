<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactReply extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The contact instance.
     */
    public $contact;

    /**
     * The reply subject.
     */
    public $subject;

    /**
     * The reply message.
     */
    public $replyMessage;

    /**
     * Create a new message instance.
     */
    public function __construct(Contact $contact, string $subject = null, string $replyMessage = null)
    {
        $this->contact = $contact;
        $this->subject = $subject ?? 'Phản hồi: ' . $contact->subject;
        $this->replyMessage = $replyMessage ?? $contact->reply;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-reply',
            with: [
                'replyMessage' => $this->replyMessage,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
} 