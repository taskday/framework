<?php

namespace Taskday\Http\Controllers;

use Taskday\Http\Controllers\BaseController;
use Taskday\Models\Card;
use Taskday\Models\Field;
use Illuminate\Http\Request;
use Taskday\Models\Project;
use Illuminate\Support\Facades\Auth;

class ProjectFieldController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Project $project
     * @param Field $field
     * @return \Illuminate\Http\Response
     */
    public function update(Project $project, Field $field, Request $request)
    {
        $data = $request->validate([
            'hidden' => 'sometimes',
            'order' => 'sometimes'
        ]);

        $project = $project->addOrUpdateField($field, $data ?? []);

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Project $project
     * @param Field $field
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project, Field $field, Request $request)
    {
        $project = $project->removeField($field);

        return redirect()->back();
    }
}
