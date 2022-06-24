<?php

namespace Taskday\Http\Controllers\Api;

use Taskday\Http\Controllers\Controller;
use Taskday\Models\Card;
use Taskday\Models\Project;
use Taskday\Models\Workspace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CardController extends Controller
{
    public function index(Request $request)
    {
        $cards = Card::query()
            ->sharedWithCurrentUser()
            ->with(['project.workspace', 'fields', 'project.fields'])
            ->when($request->has('filters.workspaces'), function ($query) use ($request) {
                $query->whereHas('project', function ($project) use ($request) {
                    $project->whereHas('workspace', function ($workspace) use ($request) {
                        $workspace->whereIn('id', $request->input('filters.workspaces.*'));
                    });
                });
            })
            ->when($request->has('filters.projects'), function ($query) use ($request) {
                $query->whereHas('project', function ($project) use ($request) {
                    $project->whereIn('id', $request->input('filters.projects.*'));
                });
            })
            ->when($request->has('filters.search'), function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->orWhereHas('project', function ($project) use ($request) {
                        $project->whereIn('id', Project::search($request->input('filters.search'))->get()->pluck('id'));
                        $project->whereHas('workspace', function ($workspace) use ($request) {
                            $workspace->whereIn('id', Workspace::search($request->input('filters.search'))->get()->pluck('id'));
                        });
                    });
                });
            })
            ->when($request->has('filters.fields'), function ($query) use ($request) {
                $query->orWhereHas('fields', function ($field) use ($request) {
                    $field->whereIn('id', $request->input('filters.fields.*'));
                });
            });

        return response()->json($cards->paginate(request('per_page', 10)));
    }

    public function show(Request $request, Card $card)
    {
        $this->authorize('view', $card);

        if ($request->get('with')) {
            $card->load($request->get('with'));
        }

        $card->load('fields', 'project.workspace', 'project.fields', 'comments.creator');

        return response()->json( $card );
    }

    public function update(Request $request, Card $card)
    {
        $this->authorize('update', $card);

        $data = $request->validate([
            'title' => 'nullable',
            'content' => 'nullable',
            'order' => 'nullable'
        ]);

        $card->update($data);

        return response()->json( $card );
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

        $data['user_id'] = Auth::id();

        $card = $project->cards()->create($data);

        $card->load('fields');

        return response()->json($card);
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
        return response()->json();
    }
}
