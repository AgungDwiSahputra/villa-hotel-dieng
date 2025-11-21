<?php

namespace App\Mail;

use App\Models\Transaksi\Transaksi;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoiceNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $transaksi;
    public $isAdminCopy;

    /**
     * Create a new message instance.
     */
    public function __construct(Transaksi $transaksi, $isAdminCopy = false)
    {
        $this->transaksi = $transaksi;
        $this->isAdminCopy = $isAdminCopy;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->isAdminCopy
            ? 'Invoice Baru - Villa Hotel Dieng'
            : 'Invoice Pembayaran - Villa Hotel Dieng';

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.invoice-notification',
            with: [
                'transaksi' => $this->transaksi,
                'produk' => $this->transaksi->produk,
                'isAdminCopy' => $this->isAdminCopy,
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