@extends('layouts.app')

@section('title', 'Assets')

@section('content')
    <a class="btn btn-primary mb-2" href="{{ route('assets.create') }}" role="button">Create Asset</a>
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
                        <td><img src="{{ action('Admin\AssetController@download', $asset->id) }}" width="150"></td>
                        <td>{{ $asset->name }}</td>
                        <td>{{ $asset->created_at }}</td>
                        <td>
                            <a class="btn btn-primary"
                               href="{{ route('assets.edit', $asset->id) }}"
                               role="button">Edit</a>
                            <form action="{{ route('assets.destroy', $asset->id)}}" method="post"
                                  class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit" dusk="delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
