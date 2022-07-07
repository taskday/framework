<?php

namespace Taskday\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;
use OwenIt\Auditing\Models\Audit;
use Taskday\Actions\UpdateCardAction;
use Taskday\Http\Requests\UpdateCardRequest;
use Taskday\Models\Card;
use Taskday\Models\CardField;
use Taskday\Models\Field;
use Taskday\Models\Project;
use Taskday\Models\Workspace;
use Taskday\Support\Page\Breadcrumb;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Inertia::render('Cards/Index', [
            'title' => 'Cards',
            'breadcrumbs' => [
                new Breadcrumb('Dashboard', route('dashboard')),
            ],
            'fields' => Field::query()
                ->orderBy('title')
                ->get(),
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
        $this->authorize('view', $card);

        $card->load([
            'audits.user',
            'comments.creator',
            'comments.media',
            'fields',
            'project.workspace',
            'project.fields'
        ]);

        return Inertia::render('Cards/Show', [
            'title' => Str::of($card->title)->replaceMatches('/.*?\//', '')->title(),
            'breadcrumbs' => $card->breadcrumbs,
            'workspace' => $card->project->workspace,
            'project' => $card->project,
            'card' => $card,
            'audits' => Audit::query()
                ->with(['user', 'auditable'])
                ->where(function ($query)  use ($card) {
                    $query->where('auditable_type', Card::class)
                        ->where('auditable_id', [$card->id]);
                })
                ->orWhere(function ($query) use ($card) {
                    $query->where('auditable_type', CardField::class)
                        ->where('auditable_id', $card->fields->map->pivot->map->id);
                })
                ->limit(10)
                ->get()
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
     * @return \Illuminate\Http\Response
     */
    public function update(
        UpdateCardRequest $request,
        UpdateCardAction $action,
        Card $card,
    ) {
        $action->handle($card, $request->validated());

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
        $card->delete();

        return redirect()->back();
    }
}
