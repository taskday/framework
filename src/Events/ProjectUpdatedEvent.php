<?php

namespace Taskday\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Taskday\Models\Card;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Bus\Dispatchable;
use Taskday\Models\Project;

class ProjectUpdatedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The card that was updated.
     *
     * @var int
     */
    public $projectId;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($projectId)
    {
        $this->projectId = $projectId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("projects.{$this->projectId}");
    }

    public function broadcastWith()
    {
        return [ 'project' => Project::find($this->projectId) ];
    }

    public function broadcastAs()
    {
        return 'ProjectUpdatedEvent';
    }
}
