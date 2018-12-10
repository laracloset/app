@extends('layouts.app')

@section('title', 'Articles')

@section('content')
    <div class="container">
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
                            <td>
                                <a class="btn btn-primary" href="{{ route('articles.show', $article->id) }}"
                                   role="button">View</a>
                                <a class="btn btn-primary"
                                   href="{{ route('articles.edit', $article->id) }}"
                                   role="button">Edit</a>
                                <form action="{{ route('articles.destroy', $article->id)}}" method="post"
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

                {{ $articles->links() }}
            </div>
        </div>
    </div>
@endsection
