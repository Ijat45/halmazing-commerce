@extends('layouts.app')

@section('title', 'Forgot Password')
@section('backUrl', route('login'))

@section('content')
    <div class="container d-flex flex-column justify-content-center align-items-center min-vh-100 py-4">
        <div class="text-center mb-4">
            <h1 class="fw-bold display-5 text-dark-green mb-0">Recover Account</h1>
            <p class="text-muted">Enter your email to reset your password.</p>
        </div>

        <div class="card border-0 shadow-lg rounded-4 w-100" style="max-width: 400px;">
            <div class="card-body p-4">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form action="{{ route('password.email') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label text-muted fw-bold small">Email Address</label>
                        <input type="email" class="form-control rounded-3 py-2 @error('email') is-invalid @enderror"
                            id="email" name="email" value="{{ old('email') }}" required autofocus
                            placeholder="name@example.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-custom rounded-pill py-2 fw-bold">
                            Send Reset Link
                        </button>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('login') }}" class="text-decoration-none small text-muted">Back to Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection