<?php

namespace Taskday\Events;

use Taskday\Models\Field;
use Taskday\Models\Card;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CardFieldUpdatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $oldValue;

    public $newValue;

    public $field;

    public $card;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string $oldValue, string $newValue, Field $field, Card $card)
    {
        $this->oldValue = $oldValue;
        $this->newValue = $newValue;
        $this->card = $card;
        $this->field = $field;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
