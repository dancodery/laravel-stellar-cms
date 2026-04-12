@extends('layouts.app')

@section('title', 'Home')
@section('content')
<div class="row justify-content-md-center">
    <div class="col col-lg-9">
        <div class="card">
            <div class="card-header"><h2>Latest Posts</h2></div>
            <div class="card-body">
                <div class="card-text">
                    @forelse( $posts as $post )
                        <div class="list-group">
                            <li class="list-group-item">
                                <h3>
                                    <a href="{{ url('/'.$post->slug) }}">{{ $post->title }}</a>
                                    @if(!Auth::guest() && ($post->user_id == Auth::user()->id || Auth::user()->is_admin()))
                                        <a href="{{ route('posts.edit', $post) }}" class="btn btn-outline-secondary float-end">
                                            {{ $post->active == '1' ? 'Edit Post' : 'Edit Draft' }}
                                        </a>
                                    @endif
                                </h3>
                                <p>{{ $post->created_at->format('M d,Y \a\t h:i a') }} By <a href="{{ url('/user/'.$post->user_id . '/posts')}}">{{ $post->author->name }}</a></p>
                            </li>
                            <li class="list-group-item">
                                <article>
                                    {{ \Illuminate\Support\Str::limit($post->body, 500) }}
                                </article>
                                <a href="{{ route('post', $post) }}">Read more</a>
                            </li>
                        </div>
                    @empty
                        There are no posts yet. Sign in now and start writing!
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
