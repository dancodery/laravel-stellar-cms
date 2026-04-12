<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;

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

Route::middleware('auth')->group(function () {
    Route::get('new-post', [PostController::class, 'create'])->name('posts.create');
    Route::post('new-post', [PostController::class, 'store'])->name('posts.store');
    Route::get('edit/{post:slug}', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::post('posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
});

Route::get('user/{id}/posts', [UserController::class, 'user_posts_all'])->where('id', '[0-9]+');

Route::get('/{post:slug}', [PostController::class, 'show'])->where('post', '[A-Za-z0-9-_]+')->name('post');
