<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/posts.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/component-chosen.css') }}" rel="stylesheet" type="text/css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Orelega+One&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/49954d4722.js" crossorigin="anonymous"></script>
    <title>@yield('title')</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark dark-color">
        <a id="app-name" class="navbar-brand" href="{{ route('post.index') }}">The Doggo Bloggo</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active home">
                    <a class="nav-link" href="{{ route('post.index') }}">Home</a>
                </li>
                <li class="nav-item about">
                    <a class="nav-link" href="{{ route('about') }}">About</a>
                </li>
                @if (Auth::check())
                    <li class="nav-item bookmarks">
                        <a class="nav-link accent-color" href="{{ route('post.bookmark') }}">My Bookmarks</a>
                    </li>
                    <li class="nav-item profile">
                        <a class="nav-link accent-color" href="{{ route('profile.index') }}">Profile</a>
                    </li>
                    <li>
                        <form method="post" action="{{ route('auth.logout') }}">
                            @csrf
                            <button type="submit" id="logout-button" class="btn btn-link">Logout</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item register">
                        <a class="nav-link" href="{{ route('registration.index') }}">Register</a>
                    </li>
                    <li class="nav-item login">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                @endif
            </ul>
        </div>
    </nav>


    <div class="container-fluid">
            <div class="col-12">
                {{-- @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif --}}
                <main>
                    {{-- @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif --}}
                    @yield('content')
                </main>
            </div>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</body>

</html>
