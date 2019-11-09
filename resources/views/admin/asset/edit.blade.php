@extends('layouts.admin.app')

@section('title', 'Edit Asset')

@section('content')
    <div class="card">
        <div class="card-header">
            Edit Asset
        </div>
        <div class="card-body">
            {!! Form::open(['route' => ['assets.update', $asset->id], 'enctype' => 'multipart/form-data' , 'method' => 'PATCH']) !!}
            <div class="form-group">
                <label for="title">File</label>
                {!! Form::file('file', ['class' => 'form-control']) !!}
            </div>
            {!! Form::button('Upload', ['class' => 'btn btn-primary', 'dusk' => 'upload', 'type' => 'submit']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
