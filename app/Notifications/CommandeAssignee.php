<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CommandeAssignee extends Notification implements ShouldQueue
{
    use Queueable;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // tu peux ajouter 'broadcast' si tu utilises Laravel Echo
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Nouvelle commande assignée')
                    ->greeting('Bonjour ' . $notifiable->name)
                    ->line('Une commande (#' . $this->order->id . ') vous a été assignée.')
                    ->line('Adresse de livraison : ' . $this->order->delivery_address)
                    ->action('Voir la commande', url('/livreur/orders/' . $this->order->id))
                    ->line('Merci de votre réactivité.');
    }

    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'message' => 'Une nouvelle commande vous a été assignée.',
            'delivery_address' => $this->order->delivery_address,
        ];
    }
}
