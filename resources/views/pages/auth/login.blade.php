@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-12 col-md-8 col-lg-5">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header text-center bg-light-green py-3">
                    <h1 class="mb-0 fw-bold text-dark fs-4">Login</h1>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        {{-- Email --}}
                        <x-form.input type="email" name="email" label="Please enter Email" required autofocus />

                        {{-- Password --}}
                        <x-form.input type="password" name="password" label="Please enter Password" required />

                        {{-- Remember Me + Forgot Password --}}
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label small" for="remember">Remember Me</label>
                            </div>
                            <a href="{{-- route('password.request') --}}" class="text-decoration-none small"
                                aria-label="Forgot your password?">
                                Forgot Password?
                            </a>
                        </div>

                        {{-- Submit --}}
                        <div class="d-grid my-3">
                            <button type="submit" class="btn btn-success bg-dark-green rounded-2 py-3 fw-bold">
                                SIGN IN
                            </button>
                        </div>

                        {{-- Register Link --}}
                        <p class="text-center small mb-0">
                            Don’t have an account?
                            <a href="{{ route('register') }}" class="text-decoration-none fw-semibold"
                                aria-label="Go to registration page">Register</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
