@extends(config('stellar-cms.layout', 'layouts.app'))

@section('title', 'Create Post')
@section('content')
<div class="row justify-content-md-center">
    <div class="col col-lg-9">
        <div class="card">
            <div class="card-header"><h2>Create post</h2></div>
            <div class="card-body">
                <form method="post" action="{{ route(config('stellar-cms.route_name_prefix', 'stellar-cms.').'posts.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input class="form-control" type="text" name="title" value="{{ old('title') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Body</label>
                        <textarea class="form-control" name="body" rows="10" required>{{ old('body') }}</textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Publish</button>
                        <button type="submit" name="save" value="1" class="btn btn-outline-secondary">Save Draft</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

