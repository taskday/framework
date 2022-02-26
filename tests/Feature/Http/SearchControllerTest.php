<?php

use Taskday\Models\Card;

it('can search for anything', function () {

    $cards = Card::factory(100)->create();

    $res = $this->get(route('api.search', ['search' => $cards[0]->title]));

    $this->followRedirects($res)->assertOk();
});
