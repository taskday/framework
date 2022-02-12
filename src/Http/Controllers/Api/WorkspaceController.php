<?php

namespace Taskday\Http\Controllers\Api;

use Taskday\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Taskday\Models\Workspace;

class WorkspaceController extends Controller
{
    public function index(Request $request)
    {
        $workspaces = Auth::user()->sharedWorkspaces();

        if ($request->get('limit')) {
            $workspaces->limit($request->get('limit'));
        }

        if ($request->get('order')) {
            $workspaces->orderBy($request->get('order'), 'asc');
        } else {
            $workspaces->orderBy('title', 'asc');
        }

        if ($request->get('with')) {
            $workspaces->with($request->get('with'));
        }

        return response()->json( $workspaces->get() );
    }

    public function show(Request $request, Workspace $workspace)
    {
        $this->authorize('view', $workspace);

        $workspace->load('projects', 'projects.cards', 'projects.fields');

        return response()->json( $workspace );
    }
}
