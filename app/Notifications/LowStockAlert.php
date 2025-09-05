<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Product;

class LowStockAlert extends Notification
{
    use Queueable;

    protected $product;

    /**
     * Create a new notification instance.
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $isAdmin = $notifiable->hasRole('admin');
        $isSeller = $notifiable->hasRole('vendeur');
        $productUrl = $isAdmin
            ? route('admin.products.edit', $this->product->id)
            : (route('vendeur.products.edit', $this->product->id) ?? '#');
        $greeting = $isAdmin ? 'Bonjour Admin' : 'Bonjour ' . $notifiable->name;
        $line = $isAdmin
            ? 'Veuillez réapprovisionner ce produit rapidement.'
            : 'Merci de réapprovisionner ce produit pour éviter une rupture.';
        return (new MailMessage)
            ->subject('🚨 Alerte Stock Faible - ' . $this->product->name)
            ->greeting($greeting)
            ->line('Le stock du produit suivant est faible :')
            ->line('**Produit :** ' . $this->product->name)
            ->line('**Stock actuel :** ' . $this->product->quantity . ' unités')
            ->line('**Seuil d\'alerte :** ' . ($this->product->min_stock_alert ?? 5) . ' unités')
            ->action('Voir le produit', $productUrl)
            ->line($line)
            ->priority(1);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'low_stock_alert',
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'current_stock' => $this->product->quantity,
            'alert_threshold' => $this->product->min_stock_alert ?? 5,
            'message' => 'Stock faible pour ' . $this->product->name . ' (' . $this->product->quantity . ' unités restantes)',
        ];
    }
}
