<?php

namespace App\Mail;

use App\Models\Invoices;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class EmailTest extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * Create a new message instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            bcc: config('mail.bcc'),
            subject: 'Test mail'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.test',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];

        $invoice = Invoices::find(2);
        if(Storage::disk('local')->exists('/invoices/' . $invoice->file_name )) {
            $filePath = storage_path('/app/invoices/' . $invoice->file_name);
            $attachments[] = Attachment::fromPath($filePath)
                ->as($filePath)
                ->withMime('application/pdf');
        }

        return $attachments;
    }
}
