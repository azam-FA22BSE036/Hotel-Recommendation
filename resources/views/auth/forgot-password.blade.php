@extends('layouts.auth_custom')

@section('title', 'Forgot Password')

@section('content')
<h3 class="mb-4 text-center text-primary text-uppercase">Forgot Password</h3>

<div class="mb-4 text-muted">
    {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
</div>

<!-- Session Status -->
@if (session('status'))
    <div class="alert alert-success mb-4" role="alert">
        {{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <!-- Email Address -->
    <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus>
        @error('email')
            <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-grid gap-2">
        <button type="submit" class="btn btn-primary py-3">Email Password Reset Link</button>
    </div>
</form>
@endsection
