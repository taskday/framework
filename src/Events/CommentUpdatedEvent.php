<?php

namespace Taskday\Events;

use Taskday\Models\Comment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CommentUpdatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The card that was updated.
     *
     * @var int
     */
    public $commentId;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($commentId)
    {
        $this->commentId = $commentId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("App.Models.Comments.{$this->cardId}.Events");
    }

    /**
     * Get the data to broadcast.
     * @return (Model|Collection<mixed, Builder>|Builder|null)[]
     */
    public function broadcastWith()
    {
        return [
            'comment' => Comment::with('creator')->find($this->cardId)
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     * @return string
     */
    public function broadcastAs()
    {
        return 'CommentUpdatedEvent';
    }
}
