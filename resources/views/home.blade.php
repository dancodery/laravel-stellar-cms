@extends('layouts.app')

@section('title', 'Home')
@section('content')
<div class="row justify-content-md-center">
    <div class="col col-lg-9">
        <div class="card">
            <div class="card-header"><h2>Letzte Einträge</h2></div>
            <div class="card-body">
                <div class="card-text">
                    @forelse( $posts as $post )
                        <div class="list-group">
                            <li class="list-group-item">
                                <h3>
                                    <a href="{{ url('/'.$post->slug) }}">{{ $post->title }}</a>
                                    @if(!Auth::guest() && ($post->user_id == Auth::user()->id || Auth::user()->is_admin()))
                                        @if($post->active == '1')
                                            <button class="btn btn-default" style="float: right"><a href="{{ url('edit/'.$post->slug)}}">Edit Post</a></button>
                                        @else
                                            <button class="btn btn-default" style="float: right"><a href="{{ url('edit/'.$post->slug)}}">Edit Draft</a></button>
                                        @endif
                                    @endif
                                </h3>
                                <p>{{ $post->created_at->format('M d,Y \a\t h:i a') }} By <a href="{{ url('/user/'.$post->user_id . '/posts')}}">{{ $post->author->name }}</a></p>
                            </li>
                            <li class="list-group-item">
                                <article>
                                    {!! Str::limit($post->body, 1500, '....... <a href='.url("/".$post->slug).'>Read More</a>') !!}
                                </article>
                            </li>
                        </div>
                    @empty
                        Bis jetzt gibt es keine Einträge. Log Dich jetzt ein und fange an zu schreiben!
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

{{--    <div class="row">--}}
{{--        <div class="col-md-10 col-md-offset-1">--}}
{{--            <div class="panel panel-default">--}}
{{--                <div class="panel-heading">--}}
{{--                    <h2>Latest Posts</h2>--}}
{{--                    @yield('title-meta')--}}
{{--                </div>--}}
{{--                <div class="panel-body">--}}
{{--                    <div class="">--}}
{{--                        @forelse( $posts as $post )--}}
{{--                            <div class="list-group">--}}
{{--                                <div class="list-group-item">--}}
{{--                                    <h3><a href="{{ url('/'.$post->slug) }}">{{ $post->title }}</a>--}}
{{--                                        @if(!Auth::guest() && ($post->user_id == Auth::user()->id || Auth::user()->is_admin()))--}}
{{--                                            @if($post->active == '1')--}}
{{--                                                <button class="btn btn-default" style="float: right"><a href="{{ url('edit/'.$post->slug)}}">Edit Post</a></button>--}}
{{--                                            @else--}}
{{--                                                <button class="btn btn-default" style="float: right"><a href="{{ url('edit/'.$post->slug)}}">Edit Draft</a></button>--}}
{{--                                            @endif--}}
{{--                                        @endif--}}
{{--                                    </h3>--}}
{{--                                    <p>{{ $post->created_at->format('M d,Y \a\t h:i a') }} By <a href="{{ url('/user/'.$post->user_id . '/posts')}}">{{ $post->author->name }}</a></p>--}}
{{--                                </div>--}}
{{--                                <div class="list-group-item">--}}
{{--                                    <article>--}}
{{--                                        {!! Str::limit($post->body, 1500, '....... <a href='.url("/".$post->slug).'>Read More</a>') !!}--}}
{{--                                    </article>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        @empty--}}
{{--                            There is no post till now. Login and write a new post now!!!.--}}
{{--                        @endforelse--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection
