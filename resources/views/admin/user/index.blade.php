@extends('layouts.admin.app')

@section('title', 'Users')

@section('content')
    <div class="card">
        <div class="card-header">
            Users
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Created At</th>
                <th>Actions</th>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td style="white-space: nowrap;">
                            <a class="btn btn-primary"
                               href="{{ route('admin.users.edit', $user->id) }}"
                               role="button">Edit</a>
                            {!! Form::open(['route' => ['admin.users.destroy', $user->id], 'class' => 'd-inline', 'method' => 'DELETE']) !!}
                            {!! Form::button('Delete', ['class' => 'btn btn-danger', 'dusk' => 'delete', 'type' => 'submit']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $users->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
