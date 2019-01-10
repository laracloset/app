@extends('layouts.app')

@section('title', 'Edit Article')

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
                    <input type="text" class="form-control" name="title" value="{{ old('title', $article->title) }}"/>
                </div>
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" class="form-control" name="slug" value="{{ old('slug', $article->slug) }}"/>
                </div>
                <div class="form-group">
                    <label for="body">Body</label>
                    <textarea class="form-control" name="body">{{ old('body', $article->body) }}</textarea>
                </div>
                <div class="form-group">
                    <label for="body">Category</label>
                    <select class="form-control" name="category[]" multiple>
                        @foreach($list as $key => $value)
                            @if($errors->any())
                                @if(collect(old('category'))->contains($key))
                                    <option value="{{ $key }}" selected>{{ $value }}</option>
                                @else
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endif
                            @else
                                @if(collect($categoryIds)->contains($key))
                                    <option value="{{ $key }}" selected>{{ $value }}</option>
                                @else
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endif
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="body">State</label>
                    <select class="form-control" name="state">
                        <option value="">Choose...</option>
                        @foreach (\App\Article::getAvailableStates() as $key => $value)
                            @if($errors->any())
                                @if ($key == old('state'))
                                    <option value="{{ $key }}" selected>{{ $value }}</option>
                                @else
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endif
                            @else
                                @if ($key == $article->state)
                                    <option value="{{ $key }}" selected>{{ $value }}</option>
                                @else
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endif
                            @endif
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" dusk="update">Update</button>
            </form>
        </div>
    </div>
@endsection
