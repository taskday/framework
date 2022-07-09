<?php

namespace Taskday\Actions;

use Illuminate\Support\Collection;
use Taskday\Http\Requests\UpdateCardRequest;
use Taskday\Models\Card;
use Taskday\Models\Field;
use Taskday\Models\Project;

class UpdateCardAction
{
    public function handle(Card $card, array|Collection $data = [])
    {
        $data['title'] = strip_tags($data['title']);

        $card->update($data);

        $card->touch();
    }
}
