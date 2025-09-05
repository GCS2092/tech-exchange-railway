<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BiWeeklyShopReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reportData;
    public $admin;

    /**
     * Create a new message instance.
     */
    public function __construct($reportData, $admin)
    {
        $this->reportData = $reportData;
        $this->admin = $admin;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '📊 Rapport Bimensuel - État de la Boutique (' . $this->reportData['period']['start'] . ' - ' . $this->reportData['period']['end'] . ')',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            htmlString: view('emails.admin.biweekly-shop-report', [
                'reportData' => $this->reportData,
                'admin' => $this->admin
            ])->render(),
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