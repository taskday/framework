<?php


namespace Taskday\Observers;

use Taskday\Events\CardUpdatedEvent;
use Taskday\Models\Card;
use Taskday\Models\User;
use Taskday\Notifications\UserTaggedNotification;
use Illuminate\Support\Facades\Auth;

class CardObserver
{
    public function created(Card $card)
    {
        //
    }

    public function updated(Card $card)
    {
        event(new CardUpdatedEvent($card->id));
    }

    public function deleted(Card $card)
    {
        //
    }
}
