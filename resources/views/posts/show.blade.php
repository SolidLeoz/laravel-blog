@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title">{{ $post->title }}</h1>
                    <p class="text-muted">Posted on {{ $post->created_at->format('F d, Y') }}</p>
                    
                    @if($post->image)
                        <img src= "{{ $post->image }}" class="img-fluid mb-3" alt="{{ $post->title }}">
                    @endif
                    
                    @if($post->video)
                        <video src="{{ $post->video }}" controls class="img-fluid mb-3"></video>
                    @endif
                    
                    <div class="mb-3">
                        @foreach($post->tags as $tag)
                            <span class="badge bg-secondary">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                    
                    <div class="card-text">
                        {!! nl2br(e($post->content)) !!}
                    </div>
                    
                    @auth
                        <div class="mt-4">
                            <a href="{{ route('posts.edit', $post) }}" class="btn btn-primary">Edit Post</a>
                            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this post?')">Delete Post</button>
                            </form>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection