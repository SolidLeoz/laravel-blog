@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Welcome to My Personal Blog</h1>
    
    @foreach($posts as $post)
        <div class="card mb-4">
            <div class="card-body">
                <h2 class="card-title">{{ $post->title }}</h2>
                <p class="card-text">{{ Str::limit($post->content, 200) }}</p>
                
                @if($post->image)
                    <img src="{{ $post->image }}" class="img-fluid mb-3" alt="{{ $post->title }}" style="max-height: 200px; width: auto;">
                @endif
                
                @if($post->video)
                    <video src="{{ $post->video }}" controls class="img-fluid mb-3"></video>
                @endif
                
                <div class="mb-3">
                    @foreach($post->tags as $tag)
                        <span class="badge bg-secondary">{{ $tag->name }}</span>
                    @endforeach
                </div>
                
                <a href="{{ route('posts.show', $post) }}" class="btn btn-primary">Read More</a>

                @auth
                            <a href="{{ route('posts.edit', $post) }}" class="btn btn-secondary">Edit</a>
                            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                            </form>
                    @endauth
            </div>
            <div class="card-footer text-muted">
                Posted on {{ $post->created_at->format('F d, Y') }}
            </div>
        </div>
    @endforeach

    {{ $posts->links() }}
    
    @if($posts->isEmpty())
        <div class="alert alert-info">
            No posts available at the moment. Check back later!
        </div>
    @endif
</div>
@endsection