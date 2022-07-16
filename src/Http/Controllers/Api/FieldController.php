<?php

namespace Taskday\Http\Controllers\Api;

use Taskday\Http\Controllers\Controller;
use Taskday\Models\Card;
use Taskday\Models\Project;
use Taskday\Models\Workspace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Taskday\Models\Field;

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $fields = Field::whereHas('projects', function ($projects) {
            $projects->whereIn('id', Auth::user()->sharedProjects->pluck('id'));
        })
        ->when(request()->has('type'), function ($query) {
            $query->where('type', request()->input('type'));
        })
        ->get();

        return response()->json($fields);
    }
}
