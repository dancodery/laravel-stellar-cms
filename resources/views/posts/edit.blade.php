@extends('layouts.app')
@section('title', 'Edit Post')
@section('content')
<div class="row justify-content-md-center">
    <div class="col col-lg-9">
        <div class="card">
        <div class="card-header">
            <h2>@yield('title')</h2>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('posts.update', $post) }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <input required="required" placeholder="Enter title here" type="text" name="title" class="form-control" value="{{ old('title', $post->title) }}"/>
                </div>
                <div class="mb-3">
                    <textarea rows="10" name="body" class="form-control">{{ old('body', $post->body) }}</textarea>
                </div>
                @if($post->active == '1')
                    <input type="submit" name='publish' class="btn btn-success" value="Update" />
                @else
                    <input type="submit" name='publish' class="btn btn-success" value="Publish" />
                @endif
                <input type="submit" name='save' class="btn btn-secondary" value="Save As Draft" />
            </form>

            <form method="post" action="{{ route('posts.destroy', $post) }}" class="mt-3">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
        </div>
    </div>
</div>
@endsection
