@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $post->title }}</div>

                <div class="card-body">
                    {{ $post->body }}
                </div>
            </div>
        </div>
    </div>
@endsection
