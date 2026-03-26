@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Posts</h1>
        <a class="btn btn-primary" href="{{ route('posts.create') }}">New Post</a>
    </div>

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    @forelse ($posts as $post)
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start gap-3">
                    <div>
                        <h5 class="card-title mb-2">
                            <a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a>
                        </h5>
                        <div class="text-muted small">
                            Category ID: {{ $post->category_id }} |
                            By: {{ $post->user->name ?? 'Unknown' }}
                        </div>
                    </div>
                    @if (!empty($post->published_at))
                        <div class="text-muted small text-end">
                            Published: {{ \Carbon\Carbon::parse($post->published_at)->toDayDateTimeString() }}
                        </div>
                    @endif
                </div>

                @if (!empty($post->image))
                    <div class="mt-3 mb-2">
                        <img
                            src="{{ asset('storage/' . $post->image) }}"
                            alt="{{ $post->title }}"
                            class="img-fluid rounded"
                            style="max-height: 220px; width: 100%; object-fit: cover;"
                        >
                    </div>
                @endif

                <p class="card-text" style="white-space: pre-wrap;">
                    {{ \Illuminate\Support\Str::limit($post->content, 200) }}
                </p>

                <div class="d-flex gap-2">
                    <a class="btn btn-sm btn-secondary" href="{{ route('posts.show', $post->id) }}">View</a>
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('posts.edit', $post->id) }}">Edit</a>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-secondary">No posts yet.</div>
    @endforelse
</div>
@endsection

