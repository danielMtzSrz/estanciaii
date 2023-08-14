<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $conversacion;
    public $msg;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($conversacion, $msg)
    {
        $this->conversacion = $conversacion;
        $this->msg = $msg;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('private.chat.' . $this->conversacion);
        // return new Channel('messanger');
    }

    public function broadcastAs()
    {
        return "chat-message";
    }

    public function broadcastWith()
    {
        return ['msg_id' => $this->msg, "conversacion_id" => $this->conversacion];
    }
}
