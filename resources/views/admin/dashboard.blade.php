@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Admin Dashboard</h1>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Post Statistics</h5>
                    <p class="card-text">Total Posts: {{ $postCount }}</p>
                    <a href="{{ route('posts.index') }}" class="btn btn-primary">Manage Posts</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Tag Statistics</h5>
                    <p class="card-text">Total Tags: {{ $tagCount }}</p>
                    <a href="{{ route('tags.index') }}" class="btn btn-primary">Manage Tags</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Quick Actions</h5>
            <a href="{{ route('posts.create') }}" class="btn btn-success">Create New Post</a>
            <a href="{{ route('tags.create') }}" class="btn btn-info">Create New Tag</a>
        </div>
    </div>
</div>
@endsection