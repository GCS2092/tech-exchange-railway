<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;

class OrderPlacedAdminNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast', 'mail'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Nouvelle commande #' . $this->order->id . ' passée par ' . $this->order->user->name,
            'order_id' => $this->order->id,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nouvelle Commande Reçue')
            ->greeting('Bonjour Admin')
            ->line('Une nouvelle commande #' . $this->order->id . ' a été passée par ' . $this->order->user->name)
            ->action('Voir les commandes', url('/admin/orders'))
            ->line('Connectez-vous pour la gérer.');
    }
}
