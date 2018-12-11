@extends('layouts.app')

@section('title', 'Articles')

@section('content')
    <div class="card">
        <div class="card-header">
            Edit Article
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('articles.update', $article->id) }}">
                @method('PATCH')
                @csrf
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" name="title" value="{{ $article->title }}"/>
                </div>
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" class="form-control" name="slug" value="{{ $article->slug }}"/>
                </div>
                <div class="form-group">
                    <label for="body">Body</label>
                    <textarea class="form-control" name="body">{{ $article->body }}</textarea>
                </div>
                <div class="form-group">
                    <label for="body">State</label>
                    <select class="form-control" name="state">
                        <option selected>Choose...</option>
                        @foreach (\App\Article::getAvailableStates() as $key => $value)
                            @if ($article->state == $key)
                                <option value="{{ $key }}" selected>{{ $value }}</option>
                            @else
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" dusk="update">Update</button>
            </form>
        </div>
    </div>
@endsection
