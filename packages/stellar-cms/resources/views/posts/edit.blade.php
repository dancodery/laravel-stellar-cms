@extends(config('stellar-cms.layout', 'layouts.app'))

@section('title', 'Edit Post')
@section('content')
<div class="row justify-content-md-center">
    <div class="col col-lg-9">
        <div class="card">
            <div class="card-header"><h2>{{ $post->active ? 'Edit Post' : 'Edit Draft' }}</h2></div>
            <div class="card-body">
                <form method="post" action="{{ route(config('stellar-cms.route_name_prefix', 'stellar-cms.').'posts.update', $post) }}">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input class="form-control" type="text" name="title" value="{{ old('title', $post->title) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Body</label>
                        <textarea class="form-control" name="body" rows="10" required>{{ old('body', $post->body) }}</textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="submit" name="save" value="1" class="btn btn-outline-secondary">Save Draft</button>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <form method="post" action="{{ route(config('stellar-cms.route_name_prefix', 'stellar-cms.').'posts.destroy', $post) }}" onsubmit="return confirm('Delete this post?')">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

