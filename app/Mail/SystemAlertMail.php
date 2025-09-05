<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SystemAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public $alertType;
    public $message;
    public $details;
    public $admin;

    /**
     * Create a new message instance.
     */
    public function __construct($alertType, $message, $details = [], $admin = null)
    {
        $this->alertType = $alertType;
        $this->message = $message;
        $this->details = $details;
        $this->admin = $admin;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $icons = [
            'error' => '🚨',
            'warning' => '⚠️',
            'info' => 'ℹ️',
            'success' => '✅',
            'security' => '🔒',
            'performance' => '⚡',
            'database' => '🗄️',
        ];

        $icon = $icons[$this->alertType] ?? '📢';
        
        return new Envelope(
            subject: $icon . ' ALERTE SYSTÈME - ' . strtoupper($this->alertType) . ' - ' . $this->message,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            htmlString: view('emails.admin.system-alert', [
                'alertType' => $this->alertType,
                'message' => $this->message,
                'details' => $this->details,
                'admin' => $this->admin,
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
