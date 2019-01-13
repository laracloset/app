@extends('layouts.app')

@section('title', 'Create Category')

@section('content')
    <div class="card">
        <div class="card-header">
            Add Category
        </div>
        <div class="card-body">
            {!! Form::open(['route' => 'categories.store']) !!}
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" value="{{ old('name') }}"/>
            </div>
            <div class="form-group">
                <label for="slug">Slug</label>
                <input type="text" class="form-control" name="slug" value="{{ old('slug') }}"/>
            </div>
            <div class="form-group">
                <label for="parent_id">Parent</label>
                <select class="form-control" name="parent_id">
                    <option value="">Choose...</option>
                    @foreach($categories as $parent)
                        @if(old('parent_id') == $parent->id)
                            <option value="{{ $parent->id }}" selected>{{ $parent->name }}</option>
                        @else
                            <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary" dusk="add">Add</button>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
