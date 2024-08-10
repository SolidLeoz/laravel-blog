@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Post</h1>
    <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $post->title) }}" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control" id="content" name="content" rows="5" required>{{ old('content', $post->content) }}</textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" id="image" name="image">
            @if($post->image)
                <img src="{{ $post->image }}" alt="Current post image" class="mt-2" style="max-width: 200px;">
            @endif
        </div>
        <div class="mb-3">
            <label for="video" class="form-label">Video</label>
            <input type="file" class="form-control" id="video" name="video">
            @if($post->video)
                <video src="{{ $post->video }}" controls class="mt-2" style="max-width: 200px;"></video>
            @endif
        </div>
        <div class="mb-3">
            <label for="tags" class="form-label">Tags (comma-separated)</label>
            <input type="text" class="form-control" id="tags" name="tags" value="{{ old('tags', $post->tags->pluck('name')->implode(', ')) }}">
        </div>
        <button type="submit" class="btn btn-primary">Update Post</button>
    </form>
</div>
@endsection