@extends('layouts.admin.app')

@section('title', 'Create User')

@section('content')
    <div class="card">
        <div class="card-header">
            Create User
        </div>
        <div class="card-body">
            {!! Form::open(['route' => 'admin.admins.store']) !!}
            <div class="form-group">
                <label for="name">Name</label>
                {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) !!}
            </div>
            <div class="form-group">
                <label for="email">{{ __('E-Mail Address') }}</label>
                {!! Form::text('email', null, ['class' => 'form-control', 'id' => 'email']) !!}
            </div>
            <div class="form-group">
                <label>{{ __('Status') }}</label>
                {!! Form::hidden('active', \App\Enums\AdminStatus::INACTIVE) !!}
                <div class="form-checkbox">
                    {!! Form::checkbox('active', \App\Enums\AdminStatus::ACTIVE, null, ['class' => 'form-checkbox', 'id' => 'active']) !!}
                    <label for="active">{{ __('Active') }}</label>
                </div>
            </div>
            <div class="form-group">
                <label for="password">{{ __('Password') }}</label>
                {!! Form::password('password', ['class' => 'form-control', 'id' => 'password']) !!}
            </div>
            <div class="form-group">
                <label for="password-confirm">{{ __('Confirm Password') }}</label>
                {!! Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'password-confirm']) !!}
            </div>
            {!! Form::button('Add', ['class' => 'btn btn-primary', 'dusk' => 'add', 'type' => 'submit']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
