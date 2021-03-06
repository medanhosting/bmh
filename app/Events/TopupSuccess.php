<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\Models\DepositLog;
use App\Models\User;

class TopupSuccess
{
    use InteractsWithSockets, SerializesModels;

    public $depositLog;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(DepositLog $depositLog, User $user)
    {
        $this->depositLog = $depositLog;
        $this->user     = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
