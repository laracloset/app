@extends('layouts.admin.app')

@section('title', 'Articles')

@section('content')
    <a class="btn btn-primary mb-2" href="{{ route('articles.create') }}" role="button">Create Article</a>
    <div class="card">
        <div class="card-header">
            Articles
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
                @foreach($articles as $article)
                    <tr>
                        <td>{{ $article->id }}</td>
                        <td>{{ $article->title }}</td>
                        <td>{{ $article->created_at }}</td>
                        <td style="white-space: nowrap;">
                            <a class="btn btn-primary" href="{{ route('articles.show', $article->id) }}"
                               role="button">View</a>
                            <a class="btn btn-primary"
                               href="{{ route('articles.edit', $article->id) }}"
                               role="button">Edit</a>
                            {!! Form::open(['route' => ['articles.destroy', $article->id], 'class' => 'd-inline', 'method' => 'DELETE']) !!}
                            {!! Form::button('Delete', ['class' => 'btn btn-danger', 'dusk' => 'delete', 'type' => 'submit']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $articles->links() }}
        </div>
    </div>
@endsection
