<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TestEvent implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $message;

    /**
     * Créer une nouvelle instance de l'événement.
     *
     * @param  string  $message
     * @return void
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Définir les canaux de diffusion.
     *
     * @return \Illuminate\Broadcasting\Channel|\Illuminate\Broadcasting\PrivateChannel
     */
    public function broadcastOn()
    {
        return new Channel('test-channel');
    }

    /**
     * Définir les données à diffuser avec l'événement.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return ['message' => $this->message];
    }
}
