@extends('layouts.main')

@section('title', 'My Profile')

@section('content')
<div id="post-background">
<div class="container-fluid">
    <div class="img-wrapper post-img">
        <img src="{{ asset('img/home-pic.jpg') }}">
    </div>
    @if (Auth::user() != null && $user->id == Auth::user()->id)
    <div class="row posts">
        <p class="light-text">Welcome to your profile.</p>
    </div>
    @endif
    <div class="row posts">
        <h3 id="name">{{ $user->name }}'s Posts</h3>
    </div>
    <div class="row posts">
        @forelse ($posts as $post)
            <div class="col-12 col-md-6">
                <div class="post">
                    <div class="container-fluid">
                        <div class="row">
                    <div class="col-10 col-sm-11 col-md-10 col-lg-11 post-name">
                        <h5> {{ $post->name }} </h5>
                    </div>
                    <div class="col-2 col-sm-1 col-md-2 col-lg-1">
                        @if (Auth::check())
                            <form method="post" action="{{ route('post.togglebookmark', ['id' => $post->id]) }}">
                                @csrf
                                @if ($post->bookmarked == true)
                                    <button type="submit"><i class="fas fa-star"></i></button>
                                @else
                                    <button type="submit"><i class="far fa-star"></i></button>
                                @endif
                            </form>
                        @endif
                    </div>
                        </div>
                    </div>
                    <p class="post-content"> {{ $post->content }} </p>
                    <a href="{{ route('post.show', ['id' => $post->id]) }}" class="btn btn-accent">Read More</a>
                </div>
            </div>
        @empty 
            @if (Auth::user() != null && $user->id == Auth::user()->id)
                <div class="row posts">
                    <p class="light-text">You haven't posted anything yet! Click <a href="{{ route('post.create')}}">here</a> to get started.</p>
                </div>
            @else 
                <div class="row posts">
                    <p class="light-text">{{ $post->name }} hasn't posted anything yet!</p>
                </div>
            @endif
        @endforelse

    </div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

@if (Auth::user() != null && $user->id == Auth::user()->id)
    <script>
        $(".nav-item").removeClass("active");
        $(".profile").addClass("active");
    </script>
@endif

@endsection