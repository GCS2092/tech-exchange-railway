<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommandAssignedToLivreur extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $user;

    public function __construct(Order $order, User $user)
    {
        $this->order = $order;
        $this->user = $user;
    }

    public function build()
    {
        if ($this->user->hasRole('admin')) {
            $view = 'emails.admin.command_assigned';
        } elseif ($this->user->hasRole('livreur')) {
            $view = 'emails.livreur.command_assigned';
        } else {
            $view = 'emails.command_assigned';
        }

        return $this->subject('Nouvelle commande assignée')
                    ->view($view);
    }
}
 