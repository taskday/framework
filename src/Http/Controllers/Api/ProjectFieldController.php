<?php

namespace Taskday\Http\Controllers\Api;

use Taskday\Http\Controllers\Controller;
use Taskday\Models\Card;
use Taskday\Models\Field;
use Illuminate\Http\Request;
use Taskday\Models\FieldProject;
use Taskday\Models\Project;

class ProjectFieldController extends Controller
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
     * @param Project $card
     * @param Field $field
     * @return \Illuminate\Http\Response
     */
    public function update(Project $project, Field $field, Request $request)
    {
        $data = $request->validate([
            'hidden' => 'sometimes'
        ]);

        $project->updateExistingPivot($field->id, $data);

        return response()->json();
    }
}
