<?php

namespace Taskday\Http\Controllers;

use Taskday\Models\Field;
use Taskday\Models\Project;
use Taskday\Models\User;
use Taskday\Models\Workspace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Taskday\Support\Page\Breadcrumb;

class ProjectController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Workspace $workspace, Request $request)
    {
        return Inertia::render('Projects/Create', [
            'title' => 'New Project in ' . $workspace->title,
            'breadcrumbs' => [
                new Breadcrumb('Dashboard', route('dashboard')),
                new Breadcrumb($workspace->title, route('workspaces.show', $workspace)),
            ],
            'workspace' => $workspace,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Workspace $workspace
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Workspace $workspace, Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'nullable'
        ]);

        /** @var User */
        $user = Auth::user();
        $project = $user->createProject($data, $workspace);

        return redirect()->route('projects.show', $project);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project, Request $request)
    {
        $this->authorize('view', $project);

        return Inertia::render('Projects/Show', [
            'title' => $project->title,
            'breadcrumbs' => $project->breadcrumbs,
            'fields' => $project->fields,
            'project' => $project->load(['cards' => function ($query) use ($request) {
                $query->with('fields', 'project', 'comments.creator');
                foreach($request->only('filters') as $handle => $filter) {
                    $query->filter($handle, $filter);
                }
            }, 'fields', 'workspace']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Workspace $workspace
     * @param Project $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $this->authorize('update', $project);

        return Inertia::render('Projects/Edit', [
            'breadcrumbs' => [
                [ 'name' =>  'Dashboard',                'href' => route('dashboard') ],
                [ 'name' =>  $project->workspace->title, 'href' => route('workspaces.show', $project->workspace) ],
                [ 'name' =>  $project->title,            'href' => route('projects.show', $project) ],
                [ 'name' =>  'Settings' ],
            ],
            'workspace' => $project->load(['fields', 'workspace.projects', 'members'])->workspace,
            'project' => $project->load(['fields', 'cards', 'workspace', 'members']),
            'fields' => Field::all(),
            'users' => Auth::user()->whereNotIn('id', $project->members->pluck('id'))->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Workspace $workspace
     * @param Project $project
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Project $project, Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
        ]);

        $project->update($data);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Workspace $workspace
     * @param Project $project
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project, Request $request)
    {
        $workspace = $project->workspace;

        $project->delete();

        return redirect()->route('workspaces.show', $workspace);
    }

    /**
     * Update users members.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateMembers(Request $request, Project $project)
    {
        $data = $request->validate([
            'members' => 'array'
        ]);

        $project->syncMembers($data['members']);

        return redirect()->back();
    }
}
