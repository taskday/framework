<?php

namespace Taskday\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Taskday\Models\Card;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Bus\Dispatchable;

class CardUpdatedEvent implements ShouldBroadcast
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
        return [
            'cards' => Card::with('fields')
                ->where('id', $this->cardId)
                ->get()
        ];
    }

    public function broadcastAs()
    {
        return 'CardUpdatedEvent';
    }
}
