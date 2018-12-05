@extends('layouts.app')

@section('title', 'Articles')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                Add Article
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('articles.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title"/>
                    </div>
                    <div class="form-group">
                        <label for="slug">Slug</label>
                        <input type="text" class="form-control" name="slug"/>
                    </div>
                    <div class="form-group">
                        <label for="body">Body</label>
                        <textarea class="form-control" name="body"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="body">State</label>
                        <select class="form-control" name="state">
                            <option selected>Choose...</option>
                            @foreach(\App\Article::getAvailableStates() as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Add</button>
                </form>
            </div>
        </div>
    </div>
@endsection
