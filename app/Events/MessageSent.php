<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageSent implements ShouldBroadcast
{
    public $message;

    public function __construct(Message $msg)
    {
        $this->message = [
            'user_name' => $msg->user->name,
            'message'   => $msg->message,
            'file'      => $msg->file,
        ];
    }

    public function broadcastOn()
    {
        return new Channel('chat');
    }

    public function broadcastAs()
    {
        return 'MessageSent';
    }
}
