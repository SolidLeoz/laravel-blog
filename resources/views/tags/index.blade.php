@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Tags</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('tags.create') }}" class="btn btn-primary mb-3">Create New Tag</a>

    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Post Count</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tags as $tag)
                        <tr>
                            <td>{{ $tag->id }}</td>
                            <td>{{ $tag->name }}</td>
                            <td>{{ $tag->posts_count }}</td>
                            <td>
                                <a href="{{ route('tags.edit', $tag) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('tags.destroy', $tag) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this tag?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $tags->links() }}
    </div>
</div>
@endsection