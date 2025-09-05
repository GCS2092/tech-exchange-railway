<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderDeliveredByLivreur extends Notification
{
    use Queueable;

    protected $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order; // Store the Order object for use in the notification
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail']; // You can also use 'database' for dashboard notifications
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $userName = $this->order->user ? $this->order->user->name : 'Client inconnu';
        $livreurName = $this->order->livreur->name ?? 'Livreur inconnu';

        return (new MailMessage)
            ->subject('📦 Livraison confirmée')
            ->greeting('Bonjour Admin,')
            ->line("Le livreur {$livreurName} a confirmé la livraison de la commande #{$this->order->id}.")
            ->action('Voir la commande', route('admin.orders.show', ['order' => $this->order->id]))
            ->line('Merci pour votre confiance !');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $livreurName = $this->order->livreur->name ?? 'Livreur inconnu';

        return [
            'message' => "La commande #{$this->order->id} a été livrée par {$livreurName}.",
            'order_id' => $this->order->id,
            'status' => 'livré',
        ];
    }
}