<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow; // Dùng Now để nhanh hơn
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CallSignalEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;
    public $toUserId;

    public function __construct($data, $toUserId)
    {
        $this->data = $data;
        $this->toUserId = $toUserId;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('chat.' . $this->toUserId);
    }
    
    public function broadcastAs()
    {
        return 'CallSignalEvent';
    }
}