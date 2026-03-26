@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
        <div>
            <h1 class="h3 mb-1">{{ $post->title }}</h1>
            <div class="text-muted small">
                Category ID: {{ $post->category_id }} |
                By: {{ $post->user->name ?? 'Unknown' }}
            </div>
        </div>
        <div class="d-flex gap-2">
            <a class="btn btn-sm btn-outline-primary" href="{{ route('posts.edit', $post->id) }}">Edit</a>
            <form
                action="{{ route('posts.destroy', $post->id) }}"
                method="POST"
                onsubmit="return confirm('Delete this post?')"
            >
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
            </form>
        </div>
    </div>

    @if (!empty($post->published_at))
        <div class="text-muted small mb-3">
            Published: {{ \Carbon\Carbon::parse($post->published_at)->toDayDateTimeString() }}
        </div>
    @endif

    @if (!empty($post->image))
        <div class="mb-3">
            <img
                src="{{ asset('storage/' . $post->image) }}"
                alt="{{ $post->title }}"
                class="img-fluid rounded"
                style="max-height: 420px; width: 100%; object-fit: cover;"
            >
        </div>
    @endif

    <div class="mb-4" style="white-space: pre-wrap;">
        {{ $post->content }}
    </div>

    <hr>

    <div class="mb-3">
        <h2 class="h5 mb-2">Comments ({{ $post->comments->count() }})</h2>
        @forelse ($post->comments as $comment)
            <div class="border rounded p-3 mb-2">
                <div class="text-muted small mb-1">
                    {{ $comment->user->name ?? 'Unknown' }}
                </div>
                <div style="white-space: pre-wrap;">{{ $comment->comment }}</div>
            </div>
        @empty
            <div class="text-muted">No comments yet.</div>
        @endforelse
    </div>

    <div class="mb-2">
        <h2 class="h5 mb-2">Likes ({{ $post->likes->count() }})</h2>
    </div>

    <a href="{{ route('posts.index') }}" class="btn btn-link px-0">Back to posts</a>
</div>
@endsection

