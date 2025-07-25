<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\Order;

class OrderStatusChangedNotification extends Notification
{
    protected $order;

    // Constructor pour passer les détails de la commande
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['database'];  // Nous utilisons la base de données pour stocker la notification
    }

    public function toDatabase($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'status' => $this->order->status,  // Nouveau statut de la commande
            'message' => 'Le statut de votre commande a été mis à jour.',
        ];
    }
}
