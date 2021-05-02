@extends('layouts.main')

@section('title', 'About')

@section('content')
<div id="post-background">
<div class="container-fluid">
    <div class="img-wrapper">
        <img src="{{ asset('img/home-pic.jpg') }}">
    </div>
    <div class="row posts post justify-content-between">
            <div class="col-sm-10 col-12">
                <h5> About The Doggo Bloggo </h5>
                <p> The Doggo Bloggo was created for dog lovers everywhere to share training tips, stories, and advice. No matter if you're a beginner who just got your first puppy or if you own three performance dogs, The Doggo Bloggo can help you out! Become a member to contribute to our community. Don't want to write your own post? You can even add to other posts to share what worked for you and your pup. From manners to tricks to herding, all types of dog advice is welcome here!</p>
            </div>
    </div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script>
    $(".nav-item").removeClass("active");
    $(".about").addClass("active");
</script>

@endsection
