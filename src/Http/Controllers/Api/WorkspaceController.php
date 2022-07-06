<?php

namespace Taskday\Http\Controllers\Api;

use Taskday\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Taskday\Models\Project;
use Taskday\Models\Workspace;

class WorkspaceController extends Controller
{
    public function index(Request $request)
    {
        $workspaces = Workspace::query()
            ->sharedWithCurrentUser()
            ->with(['projects' => function ($projects) {
                $projects->with(['comments' => function ($query) {
                    $query->limit(2);
                }]);
            }])
            ->when($request->has('filters.projects'), function ($query) use ($request) {
                $query->whereHas('projects', function ($projects) use ($request) {
                    $projects->whereIn('id', $request->input('filters.projects.*'));
                });
            })
            ->when($request->has('filters.workspaces'), function ($query) use ($request) {
                $query->whereIn('id', $request->input('filters.workspaces.*'));
            })
            ->when($request->has('filters.search') && !empty($request->input('filters.search')), function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->orWhereHas('projects', function ($projects) use ($request) {
                        $projects->whereIn('id', Project::search($request->input('filters.search'))->get()->pluck('id'));
                    })
                    ->orWhereIn('id', Workspace::search($request->input('filters.search'))->get()->pluck('id'));
                });
            })
            ->orderBy('title');

        return response()->json($workspaces->paginate(request('per_page', 10)));
    }

    public function show(Request $request, Workspace $workspace)
    {
        $this->authorize('view', $workspace);

        $workspace->load('projects', 'projects.cards', 'projects.fields');

        return response()->json($workspace);
    }
}
