@extends('layouts.main')

@section('title', 'Browse Posts')

@section('content')
<div id="post-background">
<div class="container-fluid">
    <div class="img-wrapper">
        <img src="{{ asset('img/home-pic.jpg') }}">
    </div>
    <div class="row posts">
        <div class="col-12 no-margin">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
        </div>
        <form method="post" action="{{ route('post.search') }}">
            @csrf
            <div class="row posts">
            <div class="col-12 col-md-4 no-margin">
                <label class="form-label light-text" for="name">Title</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
            </div>

            <div class="col-12 col-md-5 no-margin">
                <label class="form-label light-text" for="tags">Tags</label>
                <select id="tags" data-placeholder="Start typing a tag name" multiple class="form-control form-control-chosen" name="tags[]">
                    @foreach ($tags as $tag)
                        <?php $selected = False; ?>
                        @if (old('tags') != null)
                            @foreach (old('tags') as $oldtag)
                                @if ($tag->id == $oldtag)
                                    <?php $selected = True; ?>
                                @endif
                            @endforeach
                        @endif
                        @if ($selected)
                            <option selected value="{{ $tag->id }}">
                                {{ $tag->name }}
                            </option>
                        @else 
                            <option value="{{ $tag->id }}">
                                {{ $tag->name }}
                            </option>
                        @endif

                    @endforeach
                </select>
            </div>

            <div class="col-12 no-margin">
                <button type="submit" value="Post" class="btn btn-accent">Search</button>
            </div>
        </div>
            </form>

        @if (Auth::check())
            <div class="col-12 col-md-6">
                <div class="post">
                    <a href="{{ route('post.create') }}">
                        <h5> Add a Post </h5>
                    </a>
                </div>
            </div>
        @endif

        @foreach ($posts as $post)
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
        @endforeach

    </div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/49954d4722.js" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script><script>
    $('.form-control-chosen').chosen();
    $(".nav-item").removeClass("active");
    $(".home").addClass("active");
</script>

@endsection
