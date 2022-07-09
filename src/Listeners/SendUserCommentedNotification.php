<?php

namespace Taskday\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Taskday\Events\CommentCreatedEvent;
use Taskday\Models\Comment;
use Taskday\Models\Card;
use Taskday\Notifications\UserCommentedNotification;

class SendUserCommentedNotification
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(CommentCreatedEvent $event)
    {
        $comment = Comment::find($event->commentId);

        if ($comment && $comment->commentable instanceof Card) {
            $project = $comment->commentable->project;

            $project
                ->sharedUsers
                ->filter(fn ($user) =>
                    $user->id != $comment->creator->id
                )
                ->each(fn ($user) =>
                    $user->notify(new UserCommentedNotification($comment))
                );
        }
    }
}
