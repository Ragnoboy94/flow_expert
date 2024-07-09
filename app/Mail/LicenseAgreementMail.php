<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LicenseAgreementMail extends Mailable
{
    use Queueable, SerializesModels;
    public $organization;
    /**
     * Create a new message instance.
     */
    public function __construct($organization)
    {
        $this->organization = $organization;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Лицензионное соглашение FlowExpert',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.license_agreement',
            with: ['organization' => $this->organization]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
           /* Attachment::fromPath(public_path('downloads/license.docx'))
                ->as('license.docx')
                ->withMime('application/vnd.openxmlformats-officedocument.wordprocessingml.document'),*/
        ];
    }
}
