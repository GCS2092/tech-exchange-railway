<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\TradeOffer;

class TradeOfferNotification extends Notification
{
    use Queueable;

    protected $tradeOffer;
    protected $type;

    public function __construct(TradeOffer $tradeOffer, $type = 'new_offer')
    {
        $this->tradeOffer = $tradeOffer;
        $this->type = $type;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        $subject = $this->getSubject();
        $message = $this->getMessage();

        return (new MailMessage)
            ->subject($subject)
            ->greeting('Bonjour ' . $notifiable->name . ' !')
            ->line($message)
            ->action('Voir les détails', route('trades.my-offers'))
            ->line('Merci d\'utiliser notre plateforme !');
    }

    public function toArray($notifiable)
    {
        return [
            'trade_offer_id' => $this->tradeOffer->id,
            'type' => $this->type,
            'message' => $this->getMessage(),
            'product_name' => $this->tradeOffer->product->name,
            'offered_product_name' => $this->tradeOffer->offeredProduct->name,
            'user_name' => $this->tradeOffer->user->name,
        ];
    }

    protected function getSubject()
    {
        switch ($this->type) {
            case 'new_offer':
                return 'Nouvelle offre de troc reçue !';
            case 'offer_accepted':
                return 'Votre offre de troc a été acceptée !';
            case 'offer_rejected':
                return 'Votre offre de troc a été rejetée';
            case 'offer_cancelled':
                return 'Une offre de troc a été annulée';
            default:
                return 'Mise à jour sur votre offre de troc';
        }
    }

    protected function getMessage()
    {
        switch ($this->type) {
            case 'new_offer':
                return $this->tradeOffer->user->name . ' vous propose d\'échanger son ' . 
                       $this->tradeOffer->offeredProduct->name . ' contre votre ' . 
                       $this->tradeOffer->product->name . '.';
            
            case 'offer_accepted':
                return 'Votre offre d\'échange de ' . $this->tradeOffer->offeredProduct->name . 
                       ' contre ' . $this->tradeOffer->product->name . ' a été acceptée ! ' .
                       'Vous pouvez maintenant organiser l\'échange.';
            
            case 'offer_rejected':
                return 'Votre offre d\'échange de ' . $this->tradeOffer->offeredProduct->name . 
                       ' contre ' . $this->tradeOffer->product->name . ' a été rejetée.';
            
            case 'offer_cancelled':
                return 'Une offre de troc concernant ' . $this->tradeOffer->product->name . 
                       ' a été annulée.';
            
            default:
                return 'Mise à jour sur votre offre de troc.';
        }
    }
} 