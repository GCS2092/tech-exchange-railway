<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class UserBlockedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $admin;

    public function __construct(User $user, User $admin)
    {
        $this->user = $user;
        $this->admin = $admin;
    }

    public function build()
    {
        return $this->subject('Votre compte a été bloqué')
            ->markdown('emails.user.blocked', [
                'user' => $this->user,
                'admin' => $this->admin,
            ]);
    }
}
