@extends('layouts.admin.app')

@section('title', 'Posts')

@section('content')
    <a class="btn btn-primary mb-2" href="{{ route('admin.posts.create') }}" role="button">Create Post</a>
    <div class="card">
        <div class="card-header">
            Posts
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                <th>Id</th>
                <th>Title</th>
                <th>Created At</th>
                <th>Actions</th>
                </thead>
                <tbody>
                @foreach($posts as $post)
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->created_at }}</td>
                        <td style="white-space: nowrap;">
                            <a class="btn btn-primary" href="{{ route('admin.posts.show', $post->id) }}"
                               role="button">View</a>
                            <a class="btn btn-primary"
                               href="{{ route('admin.posts.edit', $post->id) }}"
                               role="button">Edit</a>
                            {!! Form::open(['route' => ['admin.posts.destroy', $post->id], 'class' => 'd-inline', 'method' => 'DELETE']) !!}
                            {!! Form::button('Delete', ['class' => 'btn btn-danger', 'dusk' => 'delete', 'type' => 'submit']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $posts->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
