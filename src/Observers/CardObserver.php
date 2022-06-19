<?php


namespace Taskday\Observers;

use Taskday\Events\CardUpdatedEvent;
use Taskday\Events\CardCreatedEvent;
use Taskday\Events\ProjectUpdatedEvent;
use Taskday\Models\Card;

class CardObserver
{
    public function created(Card $card)
    {
        event(new CardCreatedEvent($card->id));
        event(new ProjectUpdatedEvent($card->project_id));
    }

    public function updated(Card $card)
    {
        event(new CardUpdatedEvent($card->id));
        event(new ProjectUpdatedEvent($card->project_id));
    }

    public function deleted(Card $card)
    {
        event(new ProjectUpdatedEvent($card->project_id));
    }
}
