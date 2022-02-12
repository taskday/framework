<?php

namespace Taskday\Http\Controllers\Api;

use Taskday\Http\Controllers\Controller;
use Taskday\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Taskday\Models\Workspace;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $projects = Auth::user()->sharedProjects()->with('cards');

        if ($request->get('workspace'))  {
            $projects->where('workspace_id', Workspace::whereTitle($request->get('workspace'))->firstOrFail()->id);
        }

        if ($request->get('limit')) {
            $projects->limit($request->get('limit'));
        }

        return response()->json( $projects->get() );
    }

    public function show(Request $request, Project $project)
    {
        $this->authorize('view', $project);

        $project->load('workspace', 'fields', 'cards.fields');

        return response()->json( $project );
    }

    public function store(Request $request)
    {
        $this->authorize('update', );

        $data = $request->validate([
            'title' => 'required',
            'description' => 'nullable'
        ]);

        $project = Auth::user()->createProject($data['title'], $workspace, $data);


        return response()->json( $project );
    }
}
