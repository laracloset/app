@extends('layouts.admin.app')

@section('title', 'Edit Post')

@section('content')
    <div class="card">
        <div class="card-header">
            Edit Post
        </div>
        <div class="card-body">
            {!! Form::open(['route' => ['admin.posts.update', $post->id], 'method' => "PATCH"]) !!}
            <div class="form-group">
                <label for="title">Title</label>
                {!! Form::text('title', old('title', $post->title), ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                <label for="slug">Slug</label>
                {!! Form::text('slug', old('slug', $post->slug), ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                <label for="body">Body</label>
                {!! Form::textarea('body', old('body', $post->body), ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                <label for="category[]">Category</label>
                {!! Form::select('category[]', $categoryCollection->toArray(), old('category', $post->categories->map(function ($item, $key) {
                        return $item->id;
                    })->all()), ['class' => 'form-control', 'multiple']) !!}
            </div>
            <div class="form-group">
                <label for="state">State</label>
                {!! Form::select('state', \App\Enums\PostStatus::asSelectArray(), old('state', $post->state), [
                    'class' => 'form-control',
                    'placeholder' => 'Choose...'
                ]) !!}
            </div>
            {!! Form::button('Update', ['class' => 'btn btn-primary', 'dusk' => 'update', 'type' => 'submit']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
