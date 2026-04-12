<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
class UserController extends Controller
{
    public function user_posts_all(int $id)
    {
        $user = User::query()->findOrFail($id);
        $posts = Post::query()
            ->where('user_id', $id)
            ->with('author')
            ->latest()
            ->paginate(5);

        return view('home')->withPosts($posts)->withTitle($user->name);
    }
}
