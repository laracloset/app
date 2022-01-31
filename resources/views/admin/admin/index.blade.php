@extends('layouts.admin.app')

@section('title', 'Admins')

@section('content')
    <a class="btn btn-primary mb-2" href="{{ route('admin.admins.create') }}" role="button">Create Admin</a>
    <div class="card">
        <div class="card-header">
            Admins
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>{{ __('Status') }}</th>
                <th>Created At</th>
                <th>Actions</th>
                </thead>
                <tbody>
                @foreach($admins as $admin)
                    <tr>
                        <td>{{ $admin->id }}</td>
                        <td>{{ $admin->name }}</td>
                        <td>{{ $admin->email }}</td>
                        <td>{{ \App\Enums\AdminStatus::getDescription($admin->active) }}</td>
                        <td>{{ $admin->created_at }}</td>
                        <td style="white-space: nowrap;">
                            <a class="btn btn-primary"
                               href="{{ route('admin.admins.edit', $admin->id) }}"
                               role="button">Edit</a>
                            {!! Form::open(['route' => ['admin.admins.destroy', $admin->id], 'class' => 'd-inline', 'method' => 'DELETE']) !!}
                            {!! Form::button('Delete', ['class' => 'btn btn-danger', 'dusk' => 'delete', 'type' => 'submit']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $admins->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
