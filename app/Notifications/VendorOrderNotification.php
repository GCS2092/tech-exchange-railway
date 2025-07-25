<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;

class VendorOrderNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    protected $order;
    protected $vendorProducts;

    public function __construct(Order $order, $vendorProducts = null)
    {
        $this->order = $order;
        $this->vendorProducts = $vendorProducts;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast', 'mail'];
    }

    public function toArray($notifiable)
    {
        $productNames = $this->getVendorProductNames($notifiable);
        
        return [
            'message' => 'Nouvelle commande #' . $this->order->id . ' pour vos produits : ' . $productNames,
            'order_id' => $this->order->id,
            'customer_name' => $this->order->user->name ?? 'Client inconnu',
            'total_amount' => $this->getVendorTotal($notifiable),
            'products' => $this->getVendorProducts($notifiable),
            'status' => $this->order->status,
        ];
    }

    public function toBroadcast($notifiable)
    {
        $productNames = $this->getVendorProductNames($notifiable);
        
        return new BroadcastMessage([
            'message' => 'Nouvelle commande #' . $this->order->id . ' pour vos produits : ' . $productNames,
            'order_id' => $this->order->id,
            'customer_name' => $this->order->user->name ?? 'Client inconnu',
            'total_amount' => $this->getVendorTotal($notifiable),
            'products' => $this->getVendorProducts($notifiable),
            'status' => $this->order->status,
        ]);
    }

    public function toMail($notifiable)
    {
        $productNames = $this->getVendorProductNames($notifiable);
        $totalAmount = $this->getVendorTotal($notifiable);
        
        return (new MailMessage)
            ->subject('🛒 Nouvelle commande reçue - #' . $this->order->id)
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('Une nouvelle commande a été passée pour vos produits !')
            ->line('**Numéro de commande :** #' . $this->order->id)
            ->line('**Client :** ' . ($this->order->user->name ?? 'Client inconnu'))
            ->line('**Produits commandés :** ' . $productNames)
            ->line('**Montant total pour vos produits :** ' . number_format($totalAmount, 2) . ' XOF')
            ->action('Voir la commande', route('vendeur.orders.show', $this->order->id))
            ->line('Merci de préparer les produits commandés rapidement !');
    }

    private function getVendorProducts($notifiable)
    {
        return $this->order->products()
            ->where('seller_id', $notifiable->id)
            ->withPivot(['quantity', 'price'])
            ->get();
    }

    private function getVendorProductNames($notifiable)
    {
        $products = $this->getVendorProducts($notifiable);
        return $products->pluck('name')->implode(', ');
    }

    private function getVendorTotal($notifiable)
    {
        $products = $this->getVendorProducts($notifiable);
        $total = 0;
        
        foreach ($products as $product) {
            $quantity = $product->pivot->quantity ?? 1;
            $price = $product->pivot->price ?? $product->price;
            $total += $quantity * $price;
        }
        
        return $total;
    }
} 