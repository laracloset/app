@extends('layouts.app')

@section('title', 'View Article')

@section('content')
    <div class="card">
        <div class="card-header">
            View Article
        </div>
        <div class="card-body">
            <dl>
                <dt>Id</dt>
                <dd>{{ $article->id }}</dd>
            </dl>
            <dl>
                <dt>Title</dt>
                <dd>{{ $article->title }}</dd>
            </dl>
            <dl>
                <dt>Slug</dt>
                <dd>{{ $article->slug }}</dd>
            </dl>
            <dl>
                <dt>Body</dt>
                <dd>{{ $article->body }}</dd>
            </dl>
            <dl>
                <dt>State</dt>
                <dd>{{ \App\Article::getState($article->state) }}</dd>
            </dl>
            <dl>
                <dt>Created At</dt>
                <dd>{{ $article->created_at }}</dd>
            </dl>
            <dl>
                <dt>Updated At</dt>
                <dd>{{ $article->updated_at }}</dd>
            </dl>
        </div>
    </div>
@endsection
