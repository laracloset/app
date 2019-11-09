@extends('layouts.admin.app')

@section('title', 'Edit Article')

@section('content')
    <div class="card">
        <div class="card-header">
            Edit Article
        </div>
        <div class="card-body">
            {!! Form::open(['route' => ['articles.update', $article->id], 'method' => "PATCH"]) !!}
            <div class="form-group">
                <label for="title">Title</label>
                {!! Form::text('title', old('title', $article->title), ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                <label for="slug">Slug</label>
                {!! Form::text('slug', old('slug', $article->slug), ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                <label for="body">Body</label>
                {!! Form::textarea('body', old('body', $article->body), ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                <label for="category[]">Category</label>
                {!! Form::select('category[]', $categoryCollection->toArray(), old('category', $article->categories->map(function ($item, $key) {
                        return $item->id;
                    })->all()), ['class' => 'form-control', 'multiple']) !!}
            </div>
            <div class="form-group">
                <label for="state">State</label>
                {!! Form::select('state', \App\Article::getAvailableStates(), old('state', $article->state), [
                    'class' => 'form-control',
                    'placeholder' => 'Choose...'
                ]) !!}
            </div>
            {!! Form::button('Update', ['class' => 'btn btn-primary', 'dusk' => 'update', 'type' => 'submit']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
