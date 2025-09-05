<?php
// MessageSent.php
namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\BroadcastsEvents;
use Illuminate\Queue\SerializesModels;

class MessageSent
{
    use InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message; // Assure-toi que $message est bien l'objet Message
    }

    public function broadcastOn()
    {
        return new Channel('messages');
    }
}
