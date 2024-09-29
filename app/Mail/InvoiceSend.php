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

class InvoiceSend extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public Invoices $invoice)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invoice Send',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.invoice.send',
            with: [
                'urlPayment' => url('mollie/payment', ['pay_key' => $this->invoice->user->pay_key]),
                'urlAutoPayment' => url('mollie/autoPayment', ['pay_key' => $this->invoice->user->pay_key]),
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
        $attachments = [];

        if(Storage::disk('local')->exists('/invoices/' . $this->invoice->file_name )) {
            $filePath = storage_path('/app/invoices/' . $this->hasAttachment()->file_name);
            $attachments[] = Attachment::fromPath($filePath)
                ->as($this->invoice->filename)
                ->withMime('application/pdf');
        }
        return $attachments;
    }
}
