@extends(config('stellar-cms.layout', 'layouts.app'))

@section('title', $post?->title ?? 'Page does not exist')

@section('content')
<div class="row justify-content-md-center">
    <div class="col col-lg-9">
        <div class="card">
            <div class="card-header">
                @if($post)
                    @can('update', $post)
                        <a href="{{ route(config('stellar-cms.route_name_prefix', 'stellar-cms.').'posts.edit', $post) }}" class="btn btn-outline-secondary float-end">
                            {{ $post->active ? 'Edit Post' : 'Edit Draft' }}
                        </a>
                    @endcan
                    <h2 class="mb-1">@yield('title')</h2>
                    <p class="mb-0">
                        {{ $post->created_at->format('M d,Y \\a\\t h:i a') }}
                        By <a href="{{ route(config('stellar-cms.route_name_prefix', 'stellar-cms.').'users.posts', $post->user_id) }}">{{ $post->author?->name ?? 'Unknown' }}</a>
                    </p>
                @else
                    <h2>404</h2>
                @endif
            </div>
            <div class="card-body">
                @if($post)
                    <div class="mb-4">
                        {!! nl2br(e($post->body)) !!}
                    </div>

                    <div class="mb-2">
                        <h3>Leave a comment</h3>
                    </div>

                    @auth
                        <div class="card-body p-0 mb-4">
                            <form method="post" action="{{ route(config('stellar-cms.route_name_prefix', 'stellar-cms.').'comments.store', $post) }}">
                                @csrf
                                <div class="mb-3">
                                    <textarea required placeholder="Enter comment here" name="body" class="form-control">{{ old('body') }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-success">Post</button>
                            </form>
                        </div>
                    @else
                        <p class="text-muted">Login to comment.</p>
                    @endauth

                    @if($comments?->count())
                        <ul style="list-style: none; padding: 0" class="mb-0">
                            @foreach($comments as $comment)
                                <li class="card-body px-0">
                                    <div class="list-group">
                                        <div class="list-group-item">
                                            <h4 class="mb-1">{{ $comment->author?->name ?? 'Unknown' }}</h4>
                                            <p class="mb-0">{{ $comment->created_at->format('M d,Y \\a\\t h:i a') }}</p>
                                        </div>
                                        <div class="list-group-item">
                                            <p class="mb-0">{{ $comment->body }}</p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                @else
                    <p class="mb-0">Not found.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

