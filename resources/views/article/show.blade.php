@extends('layouts.app')

@section('title', $article->title)

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $article->title }}</div>

                <div class="card-body">
                    {{ $article->body }}
                </div>
            </div>
        </div>
    </div>
@endsection
