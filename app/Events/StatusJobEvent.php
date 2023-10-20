<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StatusJobEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $id;
    public $status;
    public $progress;

    /**
     * Create a new event instance.
     */
    public function __construct($id, $status, $progress)
    {
        $this->id = $id;
        $this->status = $status;
        $this->progress = $progress;
    }

    public function broadcastOn()
    {
        return ['yoprint-channel'];
    }

    public function broadcastAs()
    {
        return 'yoprint-event';
    }

}
