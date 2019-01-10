@extends('layouts.app')

@section('title', 'Assets')

@section('content')
    <div class="card">
        <div class="card-header">
            Edit Asset
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('assets.update', $asset->id) }}" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <div class="form-group">
                    <label for="title">File</label>
                    <input type="file" class="form-control" name="file"/>
                </div>
                <button type="submit" class="btn btn-primary" dusk="upload">Upload</button>
            </form>
        </div>
    </div>
@endsection
