@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create New Post</h1>
    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="submit_token" value="{{ $submitToken }}">
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

@push('scripts')
<script>
    // Aggiungi questo script alla tua vista create.blade.php o in un file JS separato
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const submitButton = form.querySelector('button[type="submit"]');

    form.addEventListener('submit', function() {
        // Disabilita il pulsante di invio
        submitButton.disabled = true;
        submitButton.innerHTML = 'Submitting...';
        
        // Riabilita il pulsante dopo 5 secondi (nel caso la richiesta fallisca)
        setTimeout(function() {
            submitButton.disabled = false;
            submitButton.innerHTML = 'Submit';
        }, 5000);
    });
});
</script>
@endpush
@endsection