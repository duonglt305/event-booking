<?php

namespace DG\Dissertation\Admin\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NotifyRegistration
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $attendee;

    /**
     * NotifyRegistration constructor.
     * @param $attendee
     */
    public function __construct($attendee)
    {
        $this->attendee = $attendee;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('notify-channel');
    }
}
