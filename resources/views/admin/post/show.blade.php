@extends('layouts.admin.app')

@section('title', 'View Post')

@section('content')
    <div class="card">
        <div class="card-header">
            View Post
        </div>
        <div class="card-body">
            <dl>
                <dt>Id</dt>
                <dd>{{ $post->id }}</dd>
            </dl>
            <dl>
                <dt>Title</dt>
                <dd>{{ $post->title }}</dd>
            </dl>
            <dl>
                <dt>Slug</dt>
                <dd>{{ $post->slug }}</dd>
            </dl>
            <dl>
                <dt>Body</dt>
                <dd>{{ $post->body }}</dd>
            </dl>
            <dl>
                <dt>State</dt>
                <dd>{{ \App\Enums\PostStatus::getDescription($post->state) }}</dd>
            </dl>
            <dl>
                <dt>Created At</dt>
                <dd>{{ $post->created_at }}</dd>
            </dl>
            <dl>
                <dt>Updated At</dt>
                <dd>{{ $post->updated_at }}</dd>
            </dl>
        </div>
    </div>
@endsection
