@extends('layouts.admin.app')

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
                        <td style="white-space: nowrap;">
                            <a class="btn btn-primary" href="{{ route('categories.show', $category->id) }}"
                               role="button">View</a>
                            <a class="btn btn-primary"
                               href="{{ route('categories.edit', $category->id) }}"
                               role="button">Edit</a>
                            {!! Form::open(['route' => ['categories.move_up', $category->id], 'class' => 'd-inline', 'method' => 'PATCH']) !!}
                            {!! Form::button('Delete Up', ['class' => 'btn btn-primary', 'dusk' => 'move_up_' . $category->id, 'type' => 'submit']) !!}
                            {!! Form::close() !!}
                            {!! Form::open(['route' => ['categories.move_down', $category->id], 'class' => 'd-inline', 'method' => 'PATCH']) !!}
                            {!! Form::button('Delete Down', ['class' => 'btn btn-primary', 'dusk' => 'move_down_' . $category->id, 'type' => 'submit']) !!}
                            {!! Form::close() !!}
                            {!! Form::open(['route' => ['categories.destroy', $category->id], 'class' => 'd-inline', 'method' => 'DELETE']) !!}
                            {!! Form::button('Delete', ['class' => 'btn btn-danger', 'dusk' => 'delete', 'type' => 'submit']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
