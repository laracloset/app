@extends('layouts.admin.app')

@section('title', 'Edit Category')

@section('content')
    <div class="card">
        <div class="card-header">
            Edit Category
        </div>
        <div class="card-body">
            {!! Form::open(['route' => ['admin.categories.update', $category->id], 'method' => 'PATCH']) !!}
            <div class="form-group">
                <label for="title">Name</label>
                {!! Form::text('name', old('name', $category->name), ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                <label for="slug">Slug</label>
                {!! Form::text('slug', old('slug', $category->slug), ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                <label for="parent_id">Parent</label>
                {!! Form::select('parent_id', $categoryCollection->toArray(), old('parent_id', $category->parent_id), [
                    'class' => 'form-control',
                    'placeholder' => 'Choose...'
                ]) !!}
            </div>
            {!! Form::button('Update', ['class' => 'btn btn-primary', 'dusk' => 'update', 'type' => 'submit']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
