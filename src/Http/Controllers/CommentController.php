<?php

namespace Taskday\Http\Controllers;

use Taskday\Models\Card;
use Taskday\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\FileAdder;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Card $card, Comment $comment)
    {
        $this->authorize('update', $comment);

        $comment->update(
            $request->validate([
                'body' => 'nullable|string'
            ])
        );

        return redirect()->back();
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

        return redirect()->back();
    }
}
