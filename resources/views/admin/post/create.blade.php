@extends('layouts.admin.app')

@section('title', 'Create Post')

@section('content')
    <div class="card">
        <div class="card-header">
            Add Post
        </div>
        <div class="card-body">
            {!! Form::open(['route' => 'admin.posts.store']) !!}
            <div class="form-group">
                <label for="title">Title</label>
                {!! Form::text('title', null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                <label for="slug">Slug</label>
                {!! Form::text('slug', null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                <label for="body">Body</label>
                {!! Form::textarea('body', null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                <label for="category[]">Category</label>
                {!! Form::select('category[]', $categoryCollection->toArray(), null, ['class' => 'form-control', 'multiple']) !!}
            </div>
            <div class="form-group">
                <label for="state">State</label>
                {!! Form::select('state', \App\Enums\PostStatus::asSelectArray(), null, [
                    'class' => 'form-control',
                    'placeholder' => 'Choose...'
                ]) !!}
            </div>
            {!! Form::button('Add', ['class' => 'btn btn-primary', 'dusk' => 'add', 'type' => 'submit']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
