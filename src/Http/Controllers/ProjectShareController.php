<?php

namespace Taskday\Http\Controllers;

use Taskday\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ProjectShareController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Project $project, Request $request)
    {
        return Inertia::render('Projects/Share', [
            'title' => $project->title,
            'breadcrumbs' => $project->breadcrumbs,
            'fields' => $project->fields,
            'project' => $project->load(['cards' => function ($query) use ($request) {
                $query->with('fields', 'project', 'comments.creator');

                foreach($request->get('filters', []) as $handle => $filter) {
                    if (array_key_exists('value', $filter) && array_key_exists('operator', $filter)) {
                        $query->withFieldFilter($handle, $filter['operator'], $filter['value']);
                    }
                }

                if ($request->has('sort')) {
                    $query->withFieldSorting($request->get('sort'));
                }
            }, 'fields', 'workspace']),
        ]);
    }

    /**
     * Update project share status.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'share' => 'required|boolean',
        ]);

        $project->share_uuid = $data['share'] ? Str::uuid()->toString() : null;
        $project->save();

        return redirect()->back();
    }
}
