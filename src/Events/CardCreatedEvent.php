<?php

namespace Taskday\Events;

use Taskday\Models\Card;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CardCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The card that was updated.
     *
     * @var int
     */
    public $cardId;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($cardId)
    {
        $this->cardId = $cardId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("cards.any");
    }

    public function broadcastWith()
    {
        return [ 'fields' => Card::find($this->cardId)->fields ];
    }

    public function broadcastAs()
    {
        return 'CardCreatedEvent';
    }
}
