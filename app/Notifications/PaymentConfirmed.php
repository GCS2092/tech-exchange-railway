<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PaymentConfirmed extends Notification
{
    protected $amount;
    protected $transactionId;

    public function __construct($amount, $transactionId)
    {
        $this->amount = $amount;
        $this->transactionId = $transactionId;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Paiement confirmé')
            ->greeting('Bonjour ' . $notifiable->name)
            ->line('Votre paiement a été confirmé avec succès.')
            ->line('Montant : ' . number_format($this->amount, 0, ',', ' ') . ' FCFA')
            ->line('ID Transaction : ' . $this->transactionId)
            ->line('Merci pour votre confiance.')
            ->salutation('Cordialement, l’équipe de votre boutique');
    }
}
