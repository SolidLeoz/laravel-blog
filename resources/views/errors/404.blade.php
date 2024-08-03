@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h1 class="display-1">404</h1>
    <h2 class="mb-4">Page Not Found</h2>
    
    <div class="card">
        <div class="card-body">
            <p class="card-text">
                Oops! The page you're looking for doesn't exist. 
                It might have been moved or deleted, or you might have mistyped the URL.
            </p>
            <p class="card-text">
                Don't worry, though! You can always return to our homepage and start exploring from there.
            </p>
            <a href="{{ route('home') }}" class="btn btn-primary">Return to Homepage</a>
        </div>
    </div>
</div>
@endsection