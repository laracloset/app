@extends('layouts.admin.app')

@section('title', 'Create Category')

@section('content')
    <div class="card">
        <div class="card-header">
            Add Category
        </div>
        <div class="card-body">
            {!! Form::open(['route' => 'admin.categories.store']) !!}
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                <label for="slug">Slug</label>
                {!! Form::text('slug', null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                <label for="parent_id">Parent</label>
                {!! Form::select('parent_id', $categoryCollection->toArray(), null, [
                    'class' => 'form-control',
                    'placeholder' => 'Choose...'
                ]) !!}
            </div>
            {!! Form::button('Add', ['class' => 'btn btn-primary', 'dusk' => 'add', 'type' => 'submit']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
