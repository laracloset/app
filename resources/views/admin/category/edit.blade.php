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
                    <button type="submit" class="btn btn-primary" dusk="update">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
