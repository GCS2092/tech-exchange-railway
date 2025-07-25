<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewUserCreatedNotification extends Notification
{
    use Queueable;

    public $user; // ✅ Déclaration publique obligatoire pour le test

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "Un nouvel utilisateur a été créé : {$this->user->name} ({$this->user->email})",
            'user_id' => $this->user->id,
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nouvel utilisateur inscrit')
            ->line("Un nouvel utilisateur s’est inscrit :")
            ->line("Nom : {$this->user->name}")
            ->line("Email : {$this->user->email}")
            ->action('Voir les utilisateurs', url('/admin/users'));
    }
}
