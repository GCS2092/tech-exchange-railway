<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;

class OrderStatusUpdateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $newStatus;
    public $recipient;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order, string $newStatus, $recipient = null)
    {
        $this->order = $order;
        $this->newStatus = $newStatus;
        $this->recipient = $recipient;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $statusIcons = [
            'en attente' => '⏳',
            'payé' => '💰',
            'en préparation' => '📦',
            'expédié' => '🚚',
            'en livraison' => '🚛',
            'livré' => '✅',
            'annulé' => '❌',
            'retourné' => '↩️',
            'remboursé' => '💸',
        ];

        $icon = $statusIcons[$this->newStatus] ?? '📋';
        
        return new Envelope(
            subject: $icon . ' Mise à jour de votre commande #' . $this->order->id . ' - ' . ucfirst($this->newStatus),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            htmlString: view('emails.order.status-update', [
                'order' => $this->order,
                'newStatus' => $this->newStatus,
                'recipient' => $this->recipient,
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
