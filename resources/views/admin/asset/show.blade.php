@extends('layouts.admin.app')

@section('title', 'View Asset')

@section('content')
    <div class="card">
        <div class="card-header">
            View Asset
        </div>
        <div class="card-body">
            <dl>
                <dt>Id</dt>
                <dd>{{ $asset->id }}</dd>
            </dl>
            <dl>
                <dt>Thumbnail</dt>
                <dd><img src="{{ route('admin.assets.download', $asset->id) }}" width="150"></dd>
            </dl>
            <dl>
                <dt>Name</dt>
                <dd>{{ $asset->name }}</dd>
            </dl>
            <dl>
                <dt>Type</dt>
                <dd>{{ $asset->type }}</dd>
            </dl>
            <dl>
                <dt>Size</dt>
                <dd>{{ $asset->size }}</dd>
            </dl>
            <dl>
                <dt>Created At</dt>
                <dd>{{ $asset->created_at }}</dd>
            </dl>
            <dl>
                <dt>Updated At</dt>
                <dd>{{ $asset->updated_at }}</dd>
            </dl>
        </div>
    </div>
@endsection
