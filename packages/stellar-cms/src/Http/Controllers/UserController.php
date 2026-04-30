<?php

namespace Stellar\Cms\Http\Controllers;

use Illuminate\Routing\Controller;

class UserController extends Controller
{
    public function userPostsAll(int $id)
    {
        $userModel = config('stellar-cms.models.user') ?: config('auth.providers.users.model');
        $postModel = config('stellar-cms.models.post');

        $user = $userModel::query()->findOrFail($id);
        $posts = $postModel::query()
            ->where('user_id', $id)
            ->with('author')
            ->latest()
            ->paginate((int) config('stellar-cms.per_page', 5));

        return view('stellar-cms::home')->withPosts($posts)->withTitle($user->name);
    }
}

