@extends('layouts.app')

@section('title', 'Sign In')
@section('backUrl', route('pages.home.index'))

@section('content')
    <div class="container d-flex justify-content-center align-items-center min-vh-100 py-5">
        <div class="col-12 col-md-8 col-lg-5 col-xl-4">
            {{-- Logo Section --}}
            <div class="text-center mb-4">
                <img src="{{ asset('halmazing-logo.png') }}" alt="Halmazing Logo" class="img-fluid"
                    style="max-height: 80px;">
                <h4 class="fw-bold mt-3 text-dark-green">Welcome Back!</h4>
                <p class="text-muted small">Please sign in to continue.</p>
            </div>

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4 p-md-5">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        {{-- Email --}}
                        <div class="mb-4">
                            <x-form.input type="email" name="email" label="Email Address" placeholder="name@example.com"
                                required autofocus />
                        </div>

                        {{-- Password --}}
                        <div class="mb-4">
                            <x-form.input type="password" name="password" label="Password" placeholder="Enter your password"
                                required />
                        </div>

                        {{-- Options Row --}}
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label small text-muted cursor-pointer" for="remember">Remember
                                    me</label>
                            </div>

                            <a href="{{ route('password.request') }}"
                                class="text-decoration-none small text-primary fw-semibold">
                                Forgot Password?
                            </a>
                        </div>

                        {{-- Submit --}}
                        <div class="d-grid mb-4">
                            <button type="submit"
                                class="btn btn-primary bg-dark-green border-0 rounded-pill py-3 fw-bold text-uppercase shadow-sm hover-scale">
                                Login
                            </button>
                        </div>

                        {{-- Register Link --}}
                        <div class="text-center">
                            <p class="small text-muted mb-0">
                                New to Halmazing?
                                <a href="{{ route('register') }}"
                                    class="text-decoration-none fw-bold text-dark-green">Create Account</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Footer Links/Copyright (Optional embellishment) --}}
            <div class="text-center mt-4">
                <small class="text-muted opacity-50">&copy; {{ date('Y') }} Halmazing Commerce</small>
            </div>
        </div>
    </div>
@endsection