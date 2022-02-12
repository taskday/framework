<?php

namespace Taskday\Http\Controllers\Api;

use Taskday\Http\Controllers\Controller;
use Taskday\Models\Card;
use Taskday\Models\Project;
use Taskday\Models\Workspace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('query');
        // $projectId = $request->get('project_id');
        // $workspaceId = $request->get('workspace_id');

        // if (empty($query)) {
        //     $this->results = [];
        // } else {
        //     $workspaces = Workspace::query()->whereIn('id',
        //         Workspace::search($query)
        //             ->get()
        //             ->pluck('id')
        //             ->intersect(Auth::user()->sharedWorkspaces->pluck('id'))
        //     )->get();

        //     $projects = Project::query()->whereIn('id',
        //         Project::search($query)
        //             ->get()
        //             ->pluck('id')
        //             ->intersect(Auth::user()->sharedProjects->pluck('id'))
        //     )->get();

        //     $ids = Card::search($query)->get()->pluck('id');

        //     $query = Card::distinct()
        //         ->with('project.workspace')
        //         ->withCount('comments');

        //     if ($projectId) {
        //         $query = $query->where('project_id', $projectId);
        //     }

        //     if ($workspaceId) {
        //         $query = $query->whereHas('project', function($query) use ($workspaceId) {
        //           $query->where('workspace_id', $workspaceId);
        //         });
        //     }

        //     $cards = $query->whereIn('cards.id', Auth::user()->sharedProjects->flatMap->cards->pluck('id') );
        //     $cards = $query->whereIn('cards.id', $ids)->get();
        // }

        $this->results = [
            ['name' => 'Workspaces', 'items' => Workspace::search($query)->get()],
            ['name' => 'Projects', 'items' => Project::search($query)->get()],
            ['name' => 'Cards', 'items' => Card::search($query)->get()],
        ];

        return response()->json($this->results);
    }
}
