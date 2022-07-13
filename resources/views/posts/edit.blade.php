@extends('layouts.app')
@section('title', 'Edit Post')
@section('content')
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-default">
      <div class="panel-heading">

<div class="row justify-content-md-center">
  <div class="col col-lg-9">
      <div class="card">
        <div class="card-header">
            <h2>@yield('title')</h2>
        </div>
      <div class="card-body">
        <form method="post" action='{{ url("/update") }}'>
            @csrf
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <div class="mb-3">
                <input required="required" placeholder="Enter title here" type="text" name="title" class="form-control" value="{{ $post->title }}"/>
            </div>
            <div class="mb-3">
                <textarea rows="10" name="body" class="form-control">@if(!old('body')){!! $post->body !!}@endif{!! old('body') !!}</textarea>
            </div>
            @if($post->active == '1')
                <input type="submit" name='publish' class="btn btn-success" value="Update" />
            @else
                <input type="submit" name='publish' class="btn btn-success" value="Publish" />
            @endif
                <input type="submit" name='save' class="btn btn-secondary" value="Save As Draft" />
                <a href="{{ url('delete/' . $post->id) }}" class="btn btn-danger">Delete</a>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
