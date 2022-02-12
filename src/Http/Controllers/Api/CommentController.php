<?php

namespace Taskday\Http\Controllers\Api;

use Taskday\Http\Controllers\Controller;
use Taskday\Models\Card;
use Taskday\Models\Project;
use Taskday\Models\Workspace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Taskday\Models\Comment;

class CommentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param Card $card
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Card $card, Request $request)
    {
        $data = $request->validate([
            'body' => 'required',
            'attachments' => 'nullable',
            'attachments.*' => 'file'
        ]);

        $user = Auth::user();

        /** @var Comment $comment */
        $comment = $card->comment($data, $user);

        /** @var FileAdder $files  */
        $files = $comment->addAllMediaFromRequest('attachments');

        foreach($files as $file) {
            $file->preservingOriginal()
                ->toMediaCollection()
                ->move($comment)
                ->save();
        }

        return response()->json($comment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Card $card, Comment $comment)
    {
        $comment->delete();

        return response()->json();
    }
}
