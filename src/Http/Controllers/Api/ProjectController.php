<?php

namespace Taskday\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Taskday\Http\Controllers\Controller;
use Taskday\Models\Project;
use Taskday\Models\Workspace;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $workspaces = Project::query()
            ->sharedWithCurrentUser()
            ->with(['cards', 'workspace'])
            ->when($request->has('filters.workspaces'), function ($query) use ($request) {
                $query->whereHas('workspace', function ($projects) use ($request) {
                    $projects->whereIn('id', $request->input('filters.workspaces.*'));
                });
            })
            ->when($request->has('filters.projects'), function ($query) use ($request) {
                $query->whereIn('id', [$request->input('filters.projects')]);
            })
            ->when($request->has('filters.search') && !empty($request->input('filters.search')), function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->orWhereHas('workspace', function ($projects) use ($request) {
                        $projects->whereIn('id', Workspace::search($request->input('filters.search'))->get()->pluck('id'));
                    })
                    ->orWhereIn('id', Project::search($request->input('filters.search'))->get()->pluck('id'));
                });
            })
            ->orderBy('title');

        return response()->json($workspaces->paginate(request('per_page', 10)));
    }

    public function show(Request $request, Project $project)
    {
        $this->authorize('view', $project);

        $project->load('workspace', 'fields', 'cards.fields');

        return response()->json( $project );
    }

    public function store(Request $request, Workspace $workspace)
    {
        $this->authorize('create', Project::class);

        $data = $request->validate([
            'title' => 'required',
            'description' => 'nullable'
        ]);

        $project = Auth::user()->createProject($data['title'], $workspace, $data);

        return response()->json( $project );
    }
}
