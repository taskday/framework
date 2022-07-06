<?php

namespace Taskday\Http\Controllers\Api;

use Taskday\Http\Controllers\Controller;
use Taskday\Models\Card;
use Taskday\Models\Field;
use Illuminate\Http\Request;

class CardFieldController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param Card $card
     * @param Field $field
     * @return \Illuminate\Http\Response
     */
    public function show(Card $card, Field $field)
    {
        $fieldWithPivot = $card->fields()->where('id', $field->id)->first();

        return response()->json($fieldWithPivot);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Card $card
     * @param Field $field
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Card $card, Field $field)
    {
        $data = $request->validate([
            'value' => 'present'
        ]);

        $card->setCustom($field, $data['value']);

        $card->touch();

        return response()->json();
    }
}
