<?php

namespace Stellar\Cms\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Stellar\Cms\Models\Post;
use Stellar\Cms\Http\Requests\StorePostRequest;
use Stellar\Cms\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $postModel = config('stellar-cms.models.post');

        $posts = $postModel::query()
            ->where('active', 1)
            ->with('author')
            ->latest()
            ->paginate((int) config('stellar-cms.per_page', 5));

        return view('stellar-cms::home')->withPosts($posts)->withTitle('Latest Posts');
    }

    public function create()
    {
        $postModel = config('stellar-cms.models.post');
        $this->authorize('create', $postModel);

        return view('stellar-cms::posts.create');
    }

    public function store(StorePostRequest $request)
    {
        $postModel = config('stellar-cms.models.post');
        $this->authorize('create', $postModel);

        $data = $request->validated();
        $isDraft = $request->has('save');

        $post = $postModel::create([
            'title' => trim($data['title']),
            'body' => $this->sanitizeText($data['body']),
            'slug' => $this->generateUniqueSlug($data['title']),
            'user_id' => $request->user()->id,
            'active' => $isDraft ? 0 : 1,
            'published_at' => $isDraft ? null : now(),
        ]);

        $message = $isDraft ? 'Post saved successfully' : 'Post published successfully';

        return redirect()
            ->route(config('stellar-cms.route_name_prefix', 'stellar-cms.').'posts.edit', $post)
            ->withMessage($message);
    }

    public function show(Post $post)
    {
        $comments = $post->comments()->with('author')->latest()->get();

        return view('stellar-cms::posts.show')->withPost($post)->withComments($comments);
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        return view('stellar-cms::posts.edit')->with('post', $post);
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
        $landing = $isDraft
            ? route(config('stellar-cms.route_name_prefix', 'stellar-cms.').'posts.edit', $post)
            : route(config('stellar-cms.route_name_prefix', 'stellar-cms.').'post', $post);

        return redirect($landing)->withMessage($message);
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return redirect()->route(config('stellar-cms.route_name_prefix', 'stellar-cms.').'home')->with('message', 'Post deleted successfully');
    }

    private function sanitizeText(string $value): string
    {
        return trim(strip_tags($value));
    }

    private function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $postModel = config('stellar-cms.models.post');

        $base = Str::slug($title, '-');
        $base = $base !== '' ? $base : 'post';
        $slug = $base;
        $counter = 2;

        while (
            $postModel::query()
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
