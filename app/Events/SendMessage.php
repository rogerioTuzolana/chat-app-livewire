<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/*class SendMessage
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public function __construct()
    {
        
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}*/

class SendMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user_name;
    public $user_id;
    public $message;
    public $created_at;

    public function __construct($user_name, $user_id, $message, $created_at)
    {
        $this->user_name = $user_name;
        $this->user_id = $user_id;
        $this->message = $message;
        $this->created_at = $created_at;
    }

    public function broadcastOn()
    {
        return 'chat-channel';
    }

    public function broadcastAs()
    {
        return "chat-event";
    }
}
