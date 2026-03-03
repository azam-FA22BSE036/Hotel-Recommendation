@extends('layouts.auth_custom')

@section('title', 'Login')

@section('content')
<h3 class="mb-4 text-center text-primary text-uppercase">Login</h3>
<form method="POST" action="{{ route('login') }}">
    @csrf

    <!-- Email Address -->
    <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus>
        @error('email')
            <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Password -->
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required autocomplete="current-password">
        @error('password')
            <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Remember Me -->
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
        <label class="form-check-label" for="remember_me">Remember me</label>
    </div>

    <div class="d-grid gap-2">
        <button type="submit" class="btn btn-primary py-3">Log in</button>
    </div>

    <div class="mt-3 text-center">
        @if (Route::has('password.request'))
            <a class="text-muted" href="{{ route('password.request') }}">Forgot your password?</a>
        @endif
        <br>
        <a href="{{ route('register') }}" class="text-primary">Don't have an account? Register</a>
    </div>
</form>
@endsection
