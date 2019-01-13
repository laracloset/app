@extends('layouts.app')

@section('title', 'Create Article')

@section('content')
    <div class="card">
        <div class="card-header">
            Add Article
        </div>
        <div class="card-body">
            {!! Form::open(['route' => 'articles.store']) !!}
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" name="title" value="{{ old('title') }}"/>
            </div>
            <div class="form-group">
                <label for="slug">Slug</label>
                <input type="text" class="form-control" name="slug" value="{{ old('slug') }}"/>
            </div>
            <div class="form-group">
                <label for="body">Body</label>
                <textarea class="form-control" name="body">{{ old('body') }}</textarea>
            </div>
            <div class="form-group">
                <label for="body">Category</label>
                <select class="form-control" name="category[]" multiple>
                    @foreach($list as $key => $value)
                        @if(collect(old('category'))->contains($key))
                            <option value="{{ $key }}" selected>{{ $value }}</option>
                        @else
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="body">State</label>
                <select class="form-control" name="state">
                    <option value="">Choose...</option>
                    @foreach(\App\Article::getAvailableStates() as $key => $value)
                        @if($key == old('state'))
                            <option value="{{ $key }}" selected>{{ $value }}</option>
                        @else
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary" dusk="add">Add</button>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
