<?php

namespace Taskday\Http\Controllers;

use Taskday\Models\Card;
use Taskday\Models\Field;
use Illuminate\Http\Request;

class CardFieldController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Card $card
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Card $card, Field $field)
    {
        $data = $request->validate([
            'value' => 'present'
        ]);

        $card->setCustom($field, $data['value']);

        $card->touch();

        return redirect()->back();
    }
}
