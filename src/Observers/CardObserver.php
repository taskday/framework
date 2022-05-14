<?php


namespace Taskday\Observers;

use Taskday\Events\CardUpdatedEvent;
use Taskday\Events\CardCreatedEvent;
use Taskday\Models\Card;

class CardObserver
{
    public function created(Card $card)
    {
        event(new CardCreatedEvent($card->id));
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
