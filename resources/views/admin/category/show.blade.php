@extends('layouts.app')

@section('title', 'View Category')

@section('content')
    <div class="card">
        <div class="card-header">
            View Category
        </div>
        <div class="card-body">
            <dl>
                <dt>Id</dt>
                <dd>{{ $category->id }}</dd>
            </dl>
            <dl>
                <dt>Name</dt>
                <dd>{{ $category->name }}</dd>
            </dl>
            <dl>
                <dt>Slug</dt>
                <dd>{{ $category->slug }}</dd>
            </dl>
            <dl>
                <dt>Parent Id</dt>
                <dd>{{ $category->parent_id }}</dd>
            </dl>
            <dl>
                <dt>Created At</dt>
                <dd>{{ $category->created_at }}</dd>
            </dl>
            <dl>
                <dt>Updated At</dt>
                <dd>{{ $category->updated_at }}</dd>
            </dl>
        </div>
    </div>
@endsection
