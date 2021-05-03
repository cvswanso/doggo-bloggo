@extends('layouts.main')

@section('title', 'Browse Posts')

@section('content')
<div id="post-background">
<div class="container-fluid">
    <div class="img-wrapper">
        <img src="{{ asset('img/home-pic.jpg') }}">
    </div>
    <div class="row posts">

        @foreach ($posts as $post)
            <div class="col-12 col-md-6">
                <div class="post">
                    <div class="container-fluid">
                        <div class="row">
                    <div class="col-10 col-sm-11 col-md-10 col-lg-11 post-name">
                        <h5> {{ $post->name }} </h5>
                    </div>
                    <div class="col-2 col-sm-1 col-md-2 col-lg-1">
                        <form method="post" action="{{ route('post.togglebookmark', ['id' => $post->id]) }}">
                            @csrf
                            @if ($post->bookmarked == true)
                                <button type="submit"><i class="fas fa-star"></i></button>
                            @else
                                <button type="submit"><i class="far fa-star"></i></button>
                            @endif
                        </form>
                    </div>
                        </div>
                    </div>
                    <i> Bookmarked on {{ $post->timebookmarked->format('n/j/Y') }} at
                        {{ $post->timebookmarked->format('g:i A') }}. </i>
                        <br>
                        <p class="post-content"> {{ $post->content }} </p>
                    <a href="{{ route('post.show', ['id' => $post->id]) }}" class="btn btn-accent">Read More</a>
                </div>
            </div>
        @endforeach

    </div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script>
    $(".nav-item").removeClass("active");
    $(".bookmarks").addClass("active");
</script>

@endsection
