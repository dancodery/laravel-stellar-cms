<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use \App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', [PostController::class, 'index'])->name('home');

// check for logged in user
Route::middleware('auth')->group(function () {
    Route::controller(PostController::class)->group(function () {
        // show new post form
        Route::get('new-post','create');
        // save new post
        Route::post('new-post','store');
        // edit post form
        Route::get('edit/{slug}','edit');
        // update post
        Route::post('update','update');
        // delete post
        Route::get('delete/{id}','destroy');
    });
    // add comment
    Route::post('comment/add', [CommentController::class, 'store']);
});

// display list of posts
Route::get('user/{id}/posts', [UserController::class, 'user_posts_all'])->where('id', '[0-9]+');

// display single post
Route::get('/{slug}', [PostController::class, 'show'])->where('slug', '[A-Za-z0-9-_]+')->name('post');
