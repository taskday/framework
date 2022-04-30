<?php

namespace Taskday\Http\Controllers;

use Taskday\Models\Workspace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Taskday\Models\User;
use Taskday\Support\Page\Breadcrumb;

class WorkspaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Workspaces/Index', [
            'title' => 'Workspaces',
            'breadcrumbs' => [
                new Breadcrumb('Dashboard', route('dashboard')),
                new Breadcrumb('Workspaces', route('workspaces.index')),
            ],
            'workspaces' => Workspace::query()
                ->where('team_id', Auth::user()->current_team_id)
                ->orWhereIn('id', Auth::user()->sharedWorkspaces->modelKeys())
                ->with(['projects' => function ($projects) {
                    $projects
                        ->whereIn('id', Auth::user()->sharedProjects->modelKeys())
                        ->with(['comments' => function ($query) {
                            $query->limit(3);
                        }]);
                }])
                ->latest()
                ->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response|\Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Workspaces/Create', [
            'title' => 'New Workspace',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        extract($request->validate([
            'title' => 'required',
            'description' => 'nullable'
        ]));

        /** @var User */
        $user = Auth::user();

        $workspace = $user->createWorkspace($title, $description ?? null);

        return redirect()->route('workspaces.show', $workspace);
    }

    /**
     * Display the specified resource.
     *
     * @param Workspace $workspace
     * @return \Illuminate\Http\Response
     */
    public function show(Workspace $workspace, Request $request)
    {
        $this->authorize('view', $workspace);

        return Inertia::render('Workspaces/Show', [
            'title' => $workspace->title,
            'fields' => $workspace->projects->flatMap->fields->unique('id')->values(),
            'breadcrumbs' => $workspace->breadcrumbs,
            'workspace' => $workspace->load(['projects' => function ($projects) {
                $projects->whereIn('id', Auth::user()->sharedProjects->modelKeys())->with(['comments' => function ($query) {
                    $query->limit(3);
                }]);
            }]),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Workspace $workspace)
    {
        return Inertia::render('Workspaces/Edit', [
            'title' => 'Settings of ' . $workspace->title,
            'breadcrumbs' => [
                ['name' =>  'Dashboard',          'href' => route('dashboard')],
                ['name' =>  $workspace->title,    'href' => route('workspaces.show', $workspace)],
                ['name' => 'Settings'],
            ],
            'workspace' => $workspace->load(['members', 'projects']),
            'users' => Auth::user()->whereNotIn('id', $workspace->members->pluck('id'))->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Workspace $workspace)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
        ]);

        $workspace->update($data);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Workspace $workspace)
    {
        $workspace->delete();

        return redirect()->route('workspaces.index');
    }

    /**
     * Update users members.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateMembers(Request $request, Workspace $workspace)
    {
        $data = $request->validate([
            'members' => 'array',
            'deep' => 'nullable'
        ]);

        $workspace->syncMembers($data['members']);

        if ($data['deep']) {
            $workspace->projects->map->syncMembers($data['members']);
        }

        return redirect()->back();
    }
}
