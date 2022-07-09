<?php

namespace Taskday\Notifications;

use Illuminate\Bus\Queueable;
use Taskday\Models\Comment;

class UserCommentedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        protected Comment $comment
    ) {}

    public function toPendingNotification(): PendingNotification
    {
        return (new PendingNotification())
            ->title($this->comment->creator->name  . ' commented on "' . $this->comment->commentable->title . '"')
            ->body(substr(strip_tags($this->comment->body), 0, 100) . '...')
            ->action('View comment', route('cards.show', $this->comment->commentable))
            ->user($this->comment->creator);
    }
}
