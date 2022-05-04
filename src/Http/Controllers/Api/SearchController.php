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

        $this->results = [
            [
                'name' => 'Workspaces',
                'items' => Workspace::query()
                    ->sharedWithCurrentUser()
                    ->whereIn('id', Workspace::search($query)->get()->pluck('id'))
                    ->get()
            ],
            [
                'name' => 'Projects',
                'items' => Project::query()
                    ->sharedWithCurrentUser()
                    ->whereIn('id', Project::search($query)->get()->pluck('id'))
                    ->get()
            ],
            [
                'name' => 'Cards',
                'items' => Card::query()
                    ->whereHas('project', fn ($query) => $query->sharedWithCurrentUser())
                    ->whereIn('id', Card::search($query)->get()->pluck('id'))
                    ->get()
            ],
        ];

        return response()->json($this->results);
    }
}
