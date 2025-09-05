<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;

class OrderPlacedNotification extends Notification implements ShouldBroadcast
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
            'message' => 'Votre commande #' . $this->order->id . ' a été passée avec succès.',
            'order_id' => $this->order->id,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }

    public function toMail($notifiable)
    {
        $productNames = $this->order->products->pluck('name')->implode(', ');
        $currency = $this->order->currency ?? 'XOF';
        $total = number_format($this->order->total, 2, ',', ' ');
        return (new MailMessage)
            ->subject('Nouvelle commande confirmée')
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line("Votre commande #{$this->order->id} a été enregistrée avec succès.")
            ->line('Produit(s) commandé(s) : ' . $productNames)
            ->line('Montant total : ' . $total . ' ' . $currency)
            ->action('Voir mes commandes', url('/orders'))
            ->line('Merci pour votre achat sur notre boutique ! Nous espérons vous revoir bientôt 😊');
    }
}
