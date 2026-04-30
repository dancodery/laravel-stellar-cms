<?php

namespace Stellar\Cms\Http\Controllers;

use Illuminate\Routing\Controller;
use Stellar\Cms\Http\Requests\StoreCommentRequest;
use Stellar\Cms\Models\Post;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, Post $post)
    {
        $commentModel = config('stellar-cms.models.comment');

        $commentModel::create([
            'from_user' => $request->user()->id,
            'on_post' => $post->id,
            'body' => trim(strip_tags($request->validated('body'))),
        ]);

        return redirect()
            ->route(config('stellar-cms.route_name_prefix', 'stellar-cms.').'post', $post)
            ->with('message', 'Comment published');
    }
}
