@extends('layouts.app')

@section('title', 'My collection')

@section('content')
    @include('users.profile.header')

    <div style="margin-top: 100px;">
        @if ($user_collections->isNotEmpty())
            <h1 class="h2 fw-bold text-muted"> {{ $user_collections->count() == 1 ? 'My collection' : 'My collections' }}</h1>

            <div class="row">
                @foreach ($user_collections as $collection)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <a href="{{ route('post.show', $collection->post->id) }}">
                            <img src="{{ $collection->post->image }}" alt="post id {{ $collection->post->id }}" class="grid-image">
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <h3 class="text-muted text-center">No collection Yet.</h3>
        @endif
    </div>
@endsection

