<?php


namespace Taskday\Observers;

use Taskday\Models\Comment;
use Taskday\Models\User;
use Taskday\Notifications\AddedCommentNotification;

class CommentObserver
{
    public function created(Comment $comment)
    {
        User::all()->map(function ($user) use ($comment) {
            if (!$comment->ownerIs($user)) {
                $user->notify(new AddedCommentNotification($comment));
            }
        });
    }
}
