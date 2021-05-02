@extends('layouts.main')

@section('title', 'Register')

@section('content')
    <p class="light-text">Already have an account? Please <a href="{{ route('auth.loginForm') }}">login</a>.</p>
    @if ($errors->any())
        <div class="alert alert-danger">
            <p class="error">Please correct the following errors prior to registration:</p>
            <ul class="error">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="post" action="{{ route('registration.create') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label light-text" for="name">First Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
        </div>
        <div class="mb-3">
            <label class="form-label light-text" for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}">
        </div>
        <div class="mb-3">
            <label class="form-label light-text" for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control">
        </div>
        <button type="submit" value="Register" class="btn btn-accent">Register</button>
    </form>
    <p class="type"></p>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>
        $(".nav-item").removeClass("active");
        $(".register").addClass("active");
    </script>
@endsection