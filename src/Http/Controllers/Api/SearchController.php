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
            ['name' => 'Workspaces', 'items' => Workspace::search($query)->get()],
            ['name' => 'Projects', 'items' => Project::search($query)->get()],
            ['name' => 'Cards', 'items' => Card::search($query)->get()],
        ];

        return response()->json($this->results);
    }
}
