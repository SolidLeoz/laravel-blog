@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create New Post</h1>
    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" id="image" name="image">
        </div>
        <div class="mb-3">
            <label for="video" class="form-label">Video</label>
            <input type="file" class="form-control" id="video" name="video">
        </div>
        <div class="mb-3">
            <label for="tags" class="form-label">Tags (comma-separated)</label>
            <input type="text" class="form-control" id="tags" name="tags">
        </div>
        <button type="submit" class="btn btn-primary">Create Post</button>
    </form>
</div>
@endsection