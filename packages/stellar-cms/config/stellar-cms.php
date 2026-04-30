<?php

return [
    'route_prefix' => 'blog',
    'route_name_prefix' => 'stellar-cms.',

    'public_middleware' => ['web'],
    'authenticated_middleware' => ['web', 'auth'],

    'layout' => 'layouts.app',
    'per_page' => 5,

    'models' => [
        'post' => \Stellar\Cms\Models\Post::class,
        'comment' => \Stellar\Cms\Models\Comment::class,
        'user' => config('auth.providers.users.model', \App\Models\User::class),
    ],

    'tables' => [
        'posts' => 'stellar_posts',
        'comments' => 'stellar_comments',
    ],
];

