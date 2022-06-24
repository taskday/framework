<?php

namespace Taskday\Http\Controllers;

use Taskday\Models\Field;
use Taskday\Models\Project;
use Taskday\Models\User;
use Taskday\Models\Workspace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Taskday\Models\Card;
use Taskday\Support\Page\Breadcrumb;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Inertia::render('Projects/Index', [
            'title' => 'Projects',
            'breadcrumbs' => [
                new Breadcrumb('Dashboard', route('dashboard')),
            ],
            'sort' => $request->get('sort', null),
            'filters' => request()->get('filters', []),
            'fields' => Field::select(['id','title', 'handle'])->get(),
            'workspaces' => Workspace::query()
                ->select(['id', 'title'])
                ->orderBy('title')
                ->sharedWithCurrentUser()
                ->get(),
            'projects' => Project::query()
                ->select(['id', 'title'])
                ->orderBy('title')
                ->sharedWithCurrentUser()
                ->get(),
        ]);
    }

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
            // 'cards' => Card::query()
            //     ->where('project_id', $project->id)
            //     ->with('fields', 'project', 'comments.creator')
            //     ->when($request->has('filters'), function ($query) use ($request) {
            //         foreach($request->get('filters', []) as $handle => $filter) {
            //             if (array_key_exists('value', $filter) && array_key_exists('operator', $filter)) {
            //                 $query->withFieldFilter($handle, $filter['operator'], $filter['value']);
            //             }
            //         }
            //     })
            //     ->when($request->has('sort'), function ($query) use ($request) {
            //         $query->withFieldSorting($request->get('sort'));
            //     })
            //     ->paginate(10),
            'project' => $project->load(['cards' => function ($query) use ($request) {
                $query->with('fields', 'project');

                foreach($request->get('filters', []) as $handle => $filter) {
                    if (array_key_exists('value', $filter) && array_key_exists('operator', $filter)) {
                        $query->withFieldFilter($handle, $filter['operator'], $filter['value']);
                    }
                }

                if ($request->has('sort')) {
                    $query->withFieldSorting($request->get('sort'));
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

        /** @var Taskday\Models\User */
        $user = Auth::user();

        return Inertia::render('Projects/Edit', [
            'title' => 'Project Settings',
            'breadcrumbs' => [
                new Breadcrumb('Dashboard', route('dashboard')),
                new Breadcrumb($project->workspace->title, route('workspaces.show', $project->workspace)),
                new Breadcrumb($project->title, route('projects.show', $project)),
            ],
            'project' => $project->load(['fields', 'cards', 'workspace', 'members']),
            'fields' => Field::all(),
            'users' => $user->whereNotIn('id', $project->members->pluck('id'))->get()
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
