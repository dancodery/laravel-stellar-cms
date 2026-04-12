<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Post;

class CommentController extends Controller
{
	/**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(StoreCommentRequest $request, Post $post)
    {
        Comment::create([
            'from_user' => $request->user()->id,
            'on_post' => $post->id,
            'body' => trim(strip_tags($request->validated('body'))),
        ]);

        return redirect()->route('post', $post)->with('message', 'Comment published');
    }
}
