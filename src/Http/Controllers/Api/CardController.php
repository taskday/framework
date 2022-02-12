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
        $cards = Card::with(['project.workspace', 'comments.creator'])->orderBy('updated_at', 'desc')->paginate(30);

        return response()->json($cards);
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
