@php
    $editing = isset($post) && !empty($post);
    $title = old('title', $editing ? ($post->title ?? '') : '');
    $content = old('content', $editing ? ($post->content ?? '') : '');
    $categoryId = old('category_id', $editing ? ($post->category_id ?? '') : '');
    $publishedAt = old(
        'published_at',
        $editing && !empty($post->published_at) ? \Carbon\Carbon::parse($post->published_at)->format('Y-m-d\TH:i') : ''
    );
    $buttonText = $editing ? 'Update Post' : 'Create Post';
@endphp

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if (strtoupper($method) !== 'POST')
        @method($method)
    @endif

    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input
            id="title"
            name="title"
            type="text"
            class="form-control"
            value="{{ $title }}"
            required
            maxlength="255"
        >
    </div>

    <div class="mb-3">
        <label for="content" class="form-label">Content</label>
        <textarea
            id="content"
            name="content"
            class="form-control"
            rows="6"
            required
        >{{ $content }}</textarea>
    </div>

    <div class="mb-3">
        <label for="category_id" class="form-label">Category ID</label>
        <input
            id="category_id"
            name="category_id"
            type="number"
            class="form-control"
            value="{{ $categoryId }}"
            required
        >
    </div>

    <div class="mb-3">
        <label for="published_at" class="form-label">Published At</label>
        <input
            id="published_at"
            name="published_at"
            type="datetime-local"
            class="form-control"
            value="{{ $publishedAt }}"
        >
        <div class="form-text">Leave empty to keep it unpublished.</div>
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        <input id="image" name="image" type="file" class="form-control" accept="image/*">

        @if ($editing && !empty($post->image))
            <div class="mt-2">
                <img
                    src="{{ asset('storage/' . $post->image) }}"
                    alt="{{ $post->title }}"
                    style="max-height: 160px; width: auto; border-radius: 8px;"
                >
            </div>
        @endif
    </div>

    <button type="submit" class="btn btn-primary">{{ $buttonText }}</button>
    <a href="{{ route('posts.index') }}" class="btn btn-link">Cancel</a>
</form>

