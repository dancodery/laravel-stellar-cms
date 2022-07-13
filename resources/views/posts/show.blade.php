@extends('layouts.app')

@section('title')
  @if($post)
    {{ $post->title }}
  @else
    Page does not exist
  @endif
@endsection

@section('content')
<div class="row justify-content-md-center">
    <div class="col col-lg-9">
        <div class="card">
            <div class="card-header">
                @if(!Auth::guest() && ($post->user_id == Auth::user()->id || Auth::user()->is_admin()))
                    @if($post->active == '1')
                        <button class="btn btn-default" style="float: right"><a href="{{ url('edit/'.$post->slug)}}">Edit Post</a></button>
                    @else
                        <button class="btn btn-default" style="float: right"><a href="{{ url('edit/'.$post->slug)}}">Edit Draft</a></button>
                    @endif
                @endif
                <h2>@yield('title')</h2>
                <p>{{ $post->created_at->format('M d,Y \a\t h:i a') }} By <a href="{{ url('/user/'.$post->user_id . '/posts')}}">{{ $post->author->name }}</a></p>
            </div>
            <div class="card-body">
                @if($post)
                    <div>
                        {!! $post->body !!}
                    </div>
                    <div>
                        <h2>Leave a comment</h2>
                    </div>

                    @if(Auth::guest())
                        <p>Login to Comment</p>
                    @else
                        <div class="card-body">
                            <form method="post" action="/comment/add">
                                @csrf
                                <input type="hidden" name="on_post" value="{{ $post->id }}">
                                <input type="hidden" name="slug" value="{{ $post->slug }}">

                                <div class="mb-3">
                                    <textarea required="required" placeholder="Enter comment here" name="body" class="form-control"></textarea>
                                </div>
                                <input type="submit" name="post_comment" class="btn btn-success" value="Post" />
                            </form>
                        </div>
                    @endif
                    <div>
                        @if($comments)
                            <ul style="list-style: none; padding: 0">
                                @foreach($comments as $comment)
                                    <li class="card-body">
                                        <div class="list-group">
                                            <div class="list-group-item">
                                                <h3>{{ $comment->author->name }}</h3>
                                                <p>{{ $comment->created_at->format('M d,Y \a\t h:i a') }}</p>
                                            </div>
                                            <div class="list-group-item">
                                                <p>{{ $comment->body }}</p>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @else
                    404 error
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
