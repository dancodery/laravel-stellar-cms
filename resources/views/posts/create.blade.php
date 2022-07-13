@extends('layouts.app')
@section('title')
Add New Post
@endsection
@section('content')
<div class="row justify-content-md-center">
    <div class="col col-lg-9">
        <div class="card">
            <div class="card-header">
                <h2>@yield('title')</h2>
            </div>
            <div class="card-body">
                <form action="/new-post" method="post">
                    @csrf
                    <div class="mb-3">
                        <input required="required" value="{{ old('title') }}" placeholder="Enter title here" type="text" name = "title" class="form-control" />
                    </div>
                    <div class="mb-3">
                        <textarea name="body" class="form-control">{{ old('body') }}</textarea>
                    </div>
                    <button type="submit" name="publish" class="btn btn-success">Publish</button>
                    <button type="submit" name="save" class="btn btn-light">Save Draft</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
