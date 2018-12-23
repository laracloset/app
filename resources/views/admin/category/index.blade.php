@extends('layouts.app')

@section('title', 'Categories')

@section('content')
    <a class="btn btn-primary mb-2" href="{{ route('categories.create') }}" role="button">Create Category</a>
    <div class="card">
        <div class="card-header">
            Categories
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                <th>Id</th>
                <th>Name</th>
                <th>Created At</th>
                <th>Actions</th>
                </thead>
                <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->created_at }}</td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('categories.show', $category->id) }}"
                               role="button">View</a>
                            <a class="btn btn-primary"
                               href="{{ route('categories.edit', $category->id) }}"
                               role="button">Edit</a>
                            <form action="{{ route('categories.destroy', $category->id)}}" method="post"
                                  class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit" dusk="delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $categories->links() }}
        </div>
    </div>
@endsection
