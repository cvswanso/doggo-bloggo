@extends('layouts.main')

@section('title', $post->name)

@section('content')
<div id="post-background">
<div class="container-fluid">
    <div class="img-wrapper">
        <img src="{{ asset('img/home-pic.jpg') }}">
    </div>
    <div class="top-margin">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
    </div>
    <div class="row posts post justify-content-between">
            <div class="col-sm-10 col-12">
                <h5> {{ $post->name }} </h5>
                @if ($tags != null)
                    @foreach ($tags as $tag)
                        <span class="badge dark-color white-text">#{{$tag->name}}</span>
                    @endforeach
                @endif
                <p> {{ $post->content }} </p>
                <i> Written by <a id="post-author" href="{{ route('profile.view', ['id' => $post->user_id]) }}">{{ $post->user }}</a> on {{ $post->created->format('n/j/Y') }} at
                    {{ $post->created->format('g:i A') }}. </i>
                @if (Auth::check())
                    <form method="post" action="{{ route('post.delete', ['id' => $post->id]) }}">
                        @csrf
                        <button class="btn btn-accent dark-text" type="submit" id="delete-button">Delete</button>
                    </form>
                @endif
                <br>
            </div>
            @if (Auth::check())
                <div class="col-md-2 col-lg-1">
                    <a href="{{ route('post.edit', ['id' => $post->id]) }}" class="btn btn-accent x-margin">Edit</a>
                </div>
            @endif
    </div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

@endsection
