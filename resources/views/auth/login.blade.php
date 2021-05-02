@extends('layouts.main')

@section('title', 'Login')

@section('content')
    <p class="light-text">Don't have an account? Please <a href="{{ route('registration.index') }}">register</a>.</p>
    @if ((session('error')))
        <div class="alert alert-danger">
            <p class="error">{{ (session('error')) }}</p>
        </div>
    @endif
    <form method="post" action="{{ route('auth.login') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label light-text" for="email">Email</label>
            <input type="text" id="email" name="email" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label light-text" for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control">
        </div>
        <button type="submit" value="Login" class="btn btn-accent">Login</button>
    </form>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>
        $(".nav-item").removeClass("active");
        $(".login").addClass("active");
    </script>
@endsection