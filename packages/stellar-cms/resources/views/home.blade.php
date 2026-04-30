@extends(config('stellar-cms.layout', 'layouts.app'))

@section('title', 'Blog')
@section('content')
<div class="row justify-content-md-center">
    <div class="col col-lg-9">
        <div class="card">
            <div class="card-header"><h2>{{ $title ?? 'Latest Posts' }}</h2></div>
            <div class="card-body">
                <div class="card-text">
                    @forelse($posts as $post)
                        <div class="list-group">
                            <div class="list-group-item">
                                <h3 class="mb-1">
                                    <a href="{{ route(config('stellar-cms.route_name_prefix', 'stellar-cms.').'post', $post) }}">{{ $post->title }}</a>
                                    @can('update', $post)
                                        <a href="{{ route(config('stellar-cms.route_name_prefix', 'stellar-cms.').'posts.edit', $post) }}" class="btn btn-outline-secondary float-end">
                                            {{ $post->active ? 'Edit Post' : 'Edit Draft' }}
                                        </a>
                                    @endcan
                                </h3>
                                <p class="mb-0">
                                    {{ $post->created_at->format('M d,Y \\a\\t h:i a') }}
                                    By <a href="{{ route(config('stellar-cms.route_name_prefix', 'stellar-cms.').'users.posts', $post->user_id) }}">{{ $post->author?->name ?? 'Unknown' }}</a>
                                </p>
                            </div>
                            <div class="list-group-item">
                                <article>{{ \Illuminate\Support\Str::limit($post->body, 500) }}</article>
                                <a href="{{ route(config('stellar-cms.route_name_prefix', 'stellar-cms.').'post', $post) }}">Read more</a>
                            </div>
                        </div>
                    @empty
                        <p class="mb-0">There are no posts yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="mt-3">
            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection

