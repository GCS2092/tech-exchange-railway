<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Order;

class OrderStatusUpdated extends Notification
{
    use Queueable;

    protected $order;
    protected $oldStatus;
    protected $newStatus;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order, $oldStatus, $newStatus)
    {
        $this->order = $order;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
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
        $statusLabels = [
            'en attente' => 'En attente',
            'payé' => 'Payé',
            'en préparation' => 'En préparation',
            'expédié' => 'Expédié',
            'en livraison' => 'En livraison',
            'livré' => 'Livré',
            'annulé' => 'Annulé',
            'retourné' => 'Retourné',
            'remboursé' => 'Remboursé',
        ];

        $oldStatusLabel = $statusLabels[$this->oldStatus] ?? $this->oldStatus;
        $newStatusLabel = $statusLabels[$this->newStatus] ?? $this->newStatus;

        $message = (new MailMessage)
            ->subject('📦 Mise à jour de votre commande #' . $this->order->id)
            ->greeting('Bonjour ' . $notifiable->name)
            ->line('Le statut de votre commande a été mis à jour :')
            ->line('**Commande :** #' . $this->order->id)
            ->line('**Ancien statut :** ' . $oldStatusLabel)
            ->line('**Nouveau statut :** ' . $newStatusLabel);

        // Ajouter des informations spécifiques selon le statut
        switch ($this->newStatus) {
            case 'payé':
                $message->line('✅ Votre paiement a été confirmé. Nous préparons votre commande.');
                break;
            case 'en préparation':
                $message->line('🔧 Votre commande est en cours de préparation.');
                break;
            case 'expédié':
                $message->line('📤 Votre commande a été expédiée.');
                break;
            case 'en livraison':
                $message->line('🚚 Votre commande est en cours de livraison.');
                break;
            case 'livré':
                $message->line('🎉 Votre commande a été livrée ! Merci de votre confiance.');
                break;
            case 'annulé':
                $message->line('❌ Votre commande a été annulée. Contactez-nous pour plus d\'informations.');
                break;
            case 'remboursé':
                $message->line('💰 Votre remboursement a été traité.');
                break;
        }

        $message->action('Voir ma commande', route('orders.show', $this->order->id))
            ->line('Merci de votre confiance !');

        return $message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'order_status_updated',
            'order_id' => $this->order->id,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'message' => 'Statut de la commande #' . $this->order->id . ' mis à jour : ' . $this->oldStatus . ' → ' . $this->newStatus,
        ];
    }
}
