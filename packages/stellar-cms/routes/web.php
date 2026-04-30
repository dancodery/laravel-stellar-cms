<?php

use Illuminate\Support\Facades\Route;
use Stellar\Cms\Http\Controllers\CommentController;
use Stellar\Cms\Http\Controllers\PostController;
use Stellar\Cms\Http\Controllers\UserController;

Route::group([
    'prefix' => config('stellar-cms.route_prefix', 'blog'),
    'as' => config('stellar-cms.route_name_prefix', 'stellar-cms.'),
    'middleware' => config('stellar-cms.public_middleware', ['web']),
], function (): void {
    Route::get('/', [PostController::class, 'index'])->name('home');
    Route::get('/users/{id}/posts', [UserController::class, 'userPostsAll'])
        ->whereNumber('id')
        ->name('users.posts');

    Route::get('/{post:slug}', [PostController::class, 'show'])
        ->where('post', '[A-Za-z0-9-_]+')
        ->name('post');

    Route::middleware(config('stellar-cms.authenticated_middleware', ['web', 'auth']))->group(function (): void {
        Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
        Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
        Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
        Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
        Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

        Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    });
});

