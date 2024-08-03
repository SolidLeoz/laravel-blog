@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Welcome to My Personal Blog</h1>
    
    @foreach($recentPosts as $post)
        <div class="card mb-4">
            <div class="card-body">
                <h2 class="card-title">{{ $post->title }}</h2>
                <p class="card-text">{{ Str::limit($post->content, 200) }}</p>
                
                @if($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid mb-3" alt="{{ $post->title }}" style="max-height: 200px; width: auto;">
                @endif
                
                <div class="mb-3">
                    @foreach($post->tags as $tag)
                        <span class="badge bg-secondary">{{ $tag->name }}</span>
                    @endforeach
                </div>
                
                <a href="{{ route('posts.show', $post) }}" class="btn btn-primary">Read More</a>
            </div>
            <div class="card-footer text-muted">
                Posted on {{ $post->created_at->format('F d, Y') }}
            </div>
        </div>
    @endforeach
    
    <div class="mt-4">
        <a href="{{ route('posts.index') }}" class="btn btn-secondary">View All Posts</a>
    </div>
</div>
@endsection