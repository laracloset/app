@extends('layouts.app')

@section('title', 'Articles')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Articles</div>

                <div class="card-body">
                    @foreach($articles as $article)
                        {{ $article->title }}
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
