<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\Order;

class OrderStatusUpdatedNotification extends Notification
{
    use Queueable;

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via($notifiable): array
    {
        return ['mail', 'broadcast', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject("Commande #{$this->order->id} : statut mis à jour")
                    ->line("Le statut de la commande #{$this->order->id} est maintenant « {$this->order->status} ».")
                    ->action('Voir la commande', url("/admin/orders/{$this->order->id}"))
                    ->line('Merci pour votre vigilance !');
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'order_id'   => $this->order->id,
            'status'     => $this->order->status,
            'message'    => "Statut de la commande #{$this->order->id} : {$this->order->status}",
            'updated_at' => $this->order->updated_at->toDateTimeString(),
        ]);
    }

    public function toDatabase($notifiable): array
    {
        return [
            'order_id'   => $this->order->id,
            'status'     => $this->order->status,
            'message'    => "Statut de la commande #{$this->order->id} : {$this->order->status}",
            'updated_at' => $this->order->updated_at->toDateTimeString(),
        ];
    }
}
