@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Edit Post</h1>
        <a class="btn btn-outline-secondary" href="{{ route('posts.index') }}">Back</a>
    </div>

    @include('posts._form', [
        'post' => $post,
        'action' => route('posts.update', $post->id),
        'method' => 'PUT',
    ])
</div>
@endsection

