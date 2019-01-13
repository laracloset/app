@extends('layouts.app')

@section('title', 'Create Asset')

@section('content')
    <div class="card">
        <div class="card-header">
            Add Asset
        </div>
        <div class="card-body">
            {!! Form::open(['route' => 'assets.store', 'enctype' => 'multipart/form-data']) !!}
            <div class="form-group">
                <label for="name">File</label>
                {!! Form::file('file', ['class' => 'form-control']) !!}
            </div>
            {!! Form::button('Upload', ['class' => 'btn btn-primary', 'dusk' => 'upload', 'type' => 'submit']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
