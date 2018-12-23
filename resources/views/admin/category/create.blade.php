@extends('layouts.app')

@section('title', 'Categories')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                Add Category
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('categories.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name"/>
                    </div>
                    <div class="form-group">
                        <label for="slug">Slug</label>
                        <input type="text" class="form-control" name="slug"/>
                    </div>
                    <div class="form-group">
                        <label for="parent_id">Parent</label>
                        <select class="form-control" name="parent_id">
                            <option value="">Choose...</option>
                            @foreach($categories as $parent)
                                <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" dusk="add">Add</button>
                </form>
            </div>
        </div>
    </div>
@endsection
