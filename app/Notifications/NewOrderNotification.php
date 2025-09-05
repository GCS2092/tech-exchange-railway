<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\Order;

class NewOrderNotification extends Notification
{
    use Queueable;

    private $order;

    private const DEFAULT_USER = 'Utilisateur inconnu';
    private const MESSAGE_PREFIX = 'Une nouvelle commande (#';

    public function __construct(Order $order)
    {
        // S'assurer que la relation user est bien chargée
        $this->order = $order->load('user');
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        $userName = $this->order->user->name ?? self::DEFAULT_USER;
        $message = self::MESSAGE_PREFIX . $this->order->id . ') a été passée par ' . $userName;

        return [
            'message' => $message,
            'order_id' => $this->order->id,
            'user_name' => $userName,
            'total' => $this->order->total_price,
            'status' => $this->order->status,
        ];
    }

    public function toBroadcast($notifiable)
    {
        $userName = $this->order->user->name ?? self::DEFAULT_USER;
        $message = self::MESSAGE_PREFIX . $this->order->id . ') a été passée par ' . $userName;

        return new BroadcastMessage([
            'message' => $message,
            'order_id' => $this->order->id,
            'user_name' => $userName,
            'total' => $this->order->total_price,
            'status' => $this->order->status,
        ]);
    }
}
