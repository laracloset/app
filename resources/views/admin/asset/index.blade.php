@extends('layouts.admin.app')

@section('title', 'Assets')

@section('content')
    <a class="btn btn-primary mb-2" href="{{ route('admin.assets.create') }}" role="button">Create Asset</a>
    <div class="card">
        <div class="card-header">
            Assets
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                <th>Id</th>
                <th>Thumbnail</th>
                <th>Name</th>
                <th>Created At</th>
                <th>Actions</th>
                </thead>
                <tbody>
                @foreach($assets as $asset)
                    <tr>
                        <td>{{ $asset->id }}</td>
                        <td><img src="{{ route('admin.assets.download', $asset->id) }}" width="150"></td>
                        <td>{{ $asset->name }}</td>
                        <td>{{ $asset->created_at }}</td>
                        <td style="white-space: nowrap;">
                            <a class="btn btn-primary" href="{{ route('admin.assets.show', $asset->id) }}"
                               role="button">View</a>
                            <a class="btn btn-primary" href="{{ route('admin.assets.edit', $asset->id) }}"
                               role="button">Edit</a>
                            {!! Form::open(['route' => ['admin.assets.destroy', $asset->id], 'class' => 'd-inline', 'method' => 'DELETE']) !!}
                            {!! Form::button('Delete', ['class' => 'btn btn-danger', 'dusk' => 'delete', 'type' => 'submit']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $assets->links() }}
        </div>
    </div>
@endsection
