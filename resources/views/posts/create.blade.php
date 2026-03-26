@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Create Post</h1>
        <a class="btn btn-outline-secondary" href="{{ route('posts.index') }}">Back</a>
    </div>

    @include('posts._form', [
        'post' => null,
        'action' => route('posts.store'),
        'method' => 'POST',
    ])
</div>
@endsection

