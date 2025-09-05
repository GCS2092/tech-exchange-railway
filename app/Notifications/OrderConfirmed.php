<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\Order;

class NewOrderNotification extends Notification
{
    use Queueable;

    protected $order;

    private const UNKNOWN_USER = 'Utilisateur inconnu';

    public function __construct(Order $order)
    {
        $this->order = $order->load('user');
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    protected function getNotificationMessage(): string
    {
        $userName = $this->order->user->name ?? self::UNKNOWN_USER;
        return "Une nouvelle commande (#{$this->order->id}) a été passée par {$userName}";
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->getNotificationMessage(),
            'order_id' => $this->order->id,
            'user_name' => $this->order->user->name ?? self::UNKNOWN_USER,
            'total' => $this->order->total_price,
            'status' => $this->order->status,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'message' => $this->getNotificationMessage(),
            'order_id' => $this->order->id,
            'user_name' => $this->order->user->name ?? self::UNKNOWN_USER,
            'total' => $this->order->total_price,
            'status' => $this->order->status,
        ]);
    }

    public function show($orderId)
    {
        $order = Order::with(['user', 'products'])->findOrFail($orderId);
        return view('admin.orders.show', compact('order'));
    }
}
