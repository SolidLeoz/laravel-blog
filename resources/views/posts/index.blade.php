@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Blog Posts</h1>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="viewSwitch">
            <label class="form-check-label" for="viewSwitch">Grid View</label>
        </div>
    </div>

    <div id="postsContainer" class="row">
        @foreach($posts as $post)
            <div class="col-md-4 mb-4 grid-item" style="display: none;">
                <div class="card h-100">
                    @if($post->image)
                        <img src="{{ $post->image }}" class="card-img-top" alt="{{ $post->title }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $post->title }}</h5>
                        <p class="card-text">{{ Str::limit($post->content, 100) }}</p>
                        <a href="{{ route('posts.show', $post) }}" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            </div>

            <div class="col-12 mb-4 list-item">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">{{ $post->title }}</h2>
                        <div class="mb-2">
                            @foreach($post->tags as $tag)
                                <span class="badge bg-secondary">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                        <p class="card-text">{{ Str::limit($post->content, 200) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('posts.show', $post) }}" class="btn btn-primary">Read More</a>
                            @auth
                                <div>
                                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-secondary">Edit</a>
                                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                                    </form>
                                </div>
                            @endauth
                        </div>
                    </div>
                    <div class="card-footer text-muted">
                        Posted on {{ $post->created_at->format('F d, Y') }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{ $posts->links() }}
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const viewSwitch = document.getElementById('viewSwitch');
        const postsContainer = document.getElementById('postsContainer');
        const gridItems = document.querySelectorAll('.grid-item');
        const listItems = document.querySelectorAll('.list-item');

        function setView(isGrid) {
            if (isGrid) {
                postsContainer.classList.add('row');
                gridItems.forEach(item => item.style.display = 'block');
                listItems.forEach(item => item.style.display = 'none');
            } else {
                postsContainer.classList.remove('row');
                gridItems.forEach(item => item.style.display = 'none');
                listItems.forEach(item => item.style.display = 'block');
            }
            localStorage.setItem('blogViewPreference', isGrid ? 'grid' : 'list');
        }

        // Imposta la visualizzazione iniziale basata sulla preferenza salvata
        const savedPreference = localStorage.getItem('blogViewPreference');
        const initialView = savedPreference === 'grid';
        viewSwitch.checked = initialView;
        setView(initialView);

        viewSwitch.addEventListener('change', function() {
            setView(this.checked);
        });
    });
</script>
@endpush
@endsection