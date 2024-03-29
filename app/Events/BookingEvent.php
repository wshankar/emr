<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BookingEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    // public $id;
    // public $type;
    public $patient;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($patient)
    {
        $this->patient = $patient;
        // $this->type = $type;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('BookingChannel');
    }

    public function broadcastWith()
    {
        return [
            'patientName' => $this->patient->name,
            'id' => $this->patient->id,
            'created_at' => $this->patient->created_at,
        ];
    }
}
