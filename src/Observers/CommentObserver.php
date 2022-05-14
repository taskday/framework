<?php


namespace Taskday\Observers;

use Taskday\Events\CommentCreatedEvent;
use Taskday\Models\Comment;

class CommentObserver
{
    public function created(Comment $comment)
    {
        event(new CommentCreatedEvent($comment->id));
    }
}
