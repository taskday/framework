<?php


namespace Taskday\Observers;

use Taskday\Models\Comment;
use Taskday\Models\User;
use Taskday\Notifications\AddedCommentNotification;

class CommentObserver
{
    public function created(Comment $comment)
    {
        event(new CommentCreatedEvent($comment->id));
    }
}
