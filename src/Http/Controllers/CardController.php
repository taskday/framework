<?php

namespace Taskday\Http\Controllers;

use Taskday\Models\Card;
use Taskday\Models\Field;
use Taskday\Models\Project;
use Taskday\Models\Workspace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Taskday\Notifications\UserTaggedNotification;
use Taskday\Fields\Filter;
use Taskday\Facades\Taskday;
use Illuminate\Support\Str;
use Performing\Taskday\Status\Fields\StatusField;
use Performing\Taskday\Users\Fields\UsersField;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cards = Card::with(['project.workspace', 'comments.creator', 'fields'])->orderBy('updated_at', 'desc');

        match ($request->filter) {
            'assigned_to_me' => $cards->withFieldFilter(UsersField::class, Filter::CONTAINS, Auth::id()),
            'backlog' => $cards->withFieldFilter(StatusField::class, Filter::IS_EQUAL, 'gray'),
            'to_do' => $cards->withFieldFilter(StatusField::class, Filter::IS_EQUAL, 'red'),
            'in_progress' => $cards->withFieldFilter(StatusField::class, Filter::IS_EQUAL, 'yellow'),
            'completed' => $cards->withFieldFilter(StatusField::class, Filter::IS_EQUAL, 'green'),
            default => ''
        };

        return Inertia::render('Cards/Index', [
            'title' => 'Cards',
            'currentFilter' => $request->filter,
            'breadcrumbs' => [
                [ 'name' =>  'Dashboard', 'href' => route('dashboard') ],
                [ 'name' =>  'Cards' ],
            ],
            'cards' => $cards->paginate(30),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Workspace $workspace
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Project $project)
    {
        $data = $request->validate([
            'title' => 'required'
        ]);

        $card = $project->cards()->create([
            'title' => $data['title'],
            'user_id' => Auth::id()
        ]);

        $fields = $request->validate(['fields' => 'nullable|array'])['fields'];

        foreach ($fields as $key => $value) {
            $card->setCustom(Field::where('handle', $key)->first(), $value);
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param Workspace $workspace
     * @param Card $card
     * @return \Inertia\Response
     */
    public function show(Card $card)
    {
        // $this->authorize('view', $card);
        $card->load(['comments.creator', 'fields', 'project.workspace.projects', 'project.fields']);

        return Inertia::render('Cards/Show', [
            'title' => Str::of($card->title)->replaceMatches('/.*?\//', '')->title(),
            'breadcrumbs' => [
                [ 'name' =>  'Dashboard',                      'href' => route('dashboard') ],
                [ 'name' =>  $card->project->workspace->title, 'href' => route('workspaces.show', $card->project->workspace) ],
                [ 'name' =>  $card->project->title,            'href' => route('projects.show', $card->project) ],
                [ 'name' =>  $card->title ],
            ],
            'workspace' => $card->project->workspace,
            'project' => $card->project,
            'card' => $card
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Workspace $workspace
     * @param Card $card
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  Card $card)
    {
        $data = $request->validate([
            'content' => 'nullable',
            'order' => 'nullable'
        ]);

        // $re = '/data-mention.*?data-id="(.*?)"/m';
        // preg_match_all($re, $data['content'], $matches, PREG_SET_ORDER, 0);

        // if (count($matches) > 0 && count($matches[0]) > 1) {
        //     TaskdayFacade::userClass()::whereName($matches[0][1])->first()->notify(new UserTaggedNotification($card->id));
        // }

        // $data['title'] = strip_tags($data['title']);

        $card->update($data);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Workspace $workspace
     * @param Card $card
     * @return \Illuminate\Http\Response
     */
    public function destroy(Card $card)
    {
        $project = $card->project;

        $card->delete();

        return redirect()->route('projects.show', [$project]);
    }
}
