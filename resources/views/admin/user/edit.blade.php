@extends('layouts.admin.app')

@section('title', 'Edit User')

@section('content')
    <div class="card">
        <div class="card-header">
            Edit User
        </div>
        <div class="card-body">
            {!! Form::open(['route' => ['admin.users.update', $user->id], 'method' => "PATCH"]) !!}
            <div class="form-group">
                <label for="name">Name</label>
                {!! Form::text('name', old('name', $user->name), ['class' => 'form-control', 'id' => 'name']) !!}
            </div>
            <div class="form-group">
                <label for="email">{{ __('E-Mail Address') }}</label>
                {!! Form::text('email', old('email', $user->email), ['class' => 'form-control', 'id' => 'email']) !!}
            </div>
            <div class="form-group">
                <label for="password">{{ __('Password') }}</label>
                {!! Form::password('password', ['class' => 'form-control', 'id' => 'password']) !!}
            </div>
            <div class="form-group">
                <label for="password-confirm">{{ __('Confirm Password') }}</label>
                {!! Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'password-confirm']) !!}
            </div>
            {!! Form::button('Update', ['class' => 'btn btn-primary', 'dusk' => 'update', 'type' => 'submit']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
