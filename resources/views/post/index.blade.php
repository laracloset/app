@extends('layouts.app')

@section('title', 'Posts')

@section('content')
    <div class="row justify-content-center">
        @foreach($posts as $post)
            <div>
                <h2><a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a></h2>
                <p>{{ $post->created_at->format('Y/m/d') }}</p>
                {{ $post->title }}
            </div>
        @endforeach
    </div>
@endsection
