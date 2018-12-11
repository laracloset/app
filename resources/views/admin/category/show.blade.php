@extends('layouts.app')

@section('title', 'Categories')

@section('content')
    <div class="container">
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
                    <dt>Created At</dt>
                    <dd>{{ $category->created_at }}</dd>
                </dl>
                <dl>
                    <dt>Updated At</dt>
                    <dd>{{ $category->updated_at }}</dd>
                </dl>
            </div>
        </div>
    </div>
@endsection
