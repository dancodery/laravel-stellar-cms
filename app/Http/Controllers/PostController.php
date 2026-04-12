<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::query()
            ->where('active', 1)
            ->with('author')
            ->latest()
            ->paginate(5);

        return view('home')->withPosts($posts)->withTitle('Latest Posts');
    }

    public function create()
    {
        $this->authorize('create', Post::class);

        return view('posts.create');
    }

    public function store(StorePostRequest $request)
    {
        $this->authorize('create', Post::class);

        $data = $request->validated();
        $isDraft = $request->has('save');

        $post = Post::create([
            'title' => trim($data['title']),
            'body' => $this->sanitizeText($data['body']),
            'slug' => $this->generateUniqueSlug($data['title']),
            'user_id' => $request->user()->id,
            'active' => $isDraft ? 0 : 1,
            'published_at' => $isDraft ? null : now(),
        ]);

        $message = $isDraft ? 'Post saved successfully' : 'Post published successfully';

        return redirect()->route('posts.edit', $post)->withMessage($message);
    }

    public function show(Post $post)
    {
        $comments = $post->comments()->with('author')->latest()->get();

        return view('posts.show')->withPost($post)->withComments($comments);
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        return view('posts.edit')->with('post', $post);
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $this->authorize('update', $post);

        $data = $request->validated();
        $isDraft = $request->has('save');
        $slug = $this->generateUniqueSlug($data['title'], $post->id);

        $post->fill([
            'title' => trim($data['title']),
            'body' => $this->sanitizeText($data['body']),
            'slug' => $slug,
            'active' => $isDraft ? 0 : 1,
            'published_at' => $isDraft ? null : now(),
        ]);
        $post->save();

        $message = $isDraft ? 'Post saved successfully' : 'Post updated successfully';
        $landing = $isDraft ? route('posts.edit', $post) : route('post', $post);

        return redirect($landing)->withMessage($message);
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return redirect('/')->with('message', 'Post deleted successfully');
    }

    private function sanitizeText(string $value): string
    {
        return trim(strip_tags($value));
    }

    private function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title, '-');
        $base = $base !== '' ? $base : 'post';
        $slug = $base;
        $counter = 2;

        while (
            Post::query()
                ->when($ignoreId !== null, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
