@extends('layouts.app')

@section('title', 'Create Asset')

@section('content')
    <div class="card">
        <div class="card-header">
            Add Asset
        </div>
        <div class="card-body">
            {!! Form::open(['route' => 'assets.store', 'enctype' => 'multipart/form-data']) !!}
            @csrf
            <div class="form-group">
                <label for="name">File</label>
                <input type="file" class="form-control" name="file"/>
            </div>
            <button type="submit" class="btn btn-primary" dusk="upload">Upload</button>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
