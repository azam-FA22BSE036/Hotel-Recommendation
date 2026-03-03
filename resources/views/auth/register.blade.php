@extends('layouts.auth_custom')

@section('title', 'Register')

@section('content')
<h3 class="mb-4 text-center text-primary text-uppercase">Register</h3>
<form method="POST" action="{{ route('register') }}">
    @csrf

    <!-- Name -->
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
        @error('name')
            <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Email Address -->
    <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autocomplete="username">
        @error('email')
            <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Password -->
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required autocomplete="new-password">
        @error('password')
            <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Confirm Password -->
    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
        @error('password_confirmation')
            <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-grid gap-2">
        <button type="submit" class="btn btn-primary py-3">Register</button>
    </div>

    <div class="mt-3 text-center">
        <a href="{{ route('login') }}" class="text-primary">Already registered? Login</a>
    </div>
</form>
@endsection
