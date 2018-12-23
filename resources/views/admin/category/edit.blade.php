@extends('layouts.app')

@section('title', 'Categories')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                Edit Category
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('categories.update', $category->id) }}">
                    @method('PATCH')
                    @csrf
                    <div class="form-group">
                        <label for="title">Name</label>
                        <input type="text" class="form-control" name="name" value="{{ $category->name }}"/>
                    </div>
                    <div class="form-group">
                        <label for="slug">Slug</label>
                        <input type="text" class="form-control" name="slug" value="{{ $category->slug }}"/>
                    </div>
                    <div class="form-group">
                        <label for="parent_id">Parent</label>
                        <select class="form-control" name="parent_id">
                            <option value="">Choose...</option>
                            @foreach($categories as $parent)
                                @if($parent->id == $category->parent_id)
                                    <option value="{{ $parent->id }}" selected>{{ $parent->name }}</option>
                                @else
                                    <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" dusk="update">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
