@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-12 col-md-8 col-lg-5">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header text-center bg-light-green py-3">
                <h1 class="mb-0 fw-bold text-dark fs-4">Register</h1>
            </div>

            <div class="card-body p-4">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    {{-- Name --}}
                    <x-form.input name="name" label="Please enter your name" required autofocus />

                    {{-- Email --}}
                    <x-form.input type="email" name="email" label="Please enter Email" required />

                    {{-- Password --}}
                    <x-form.input type="password" name="password" label="Please enter password" required />

                    {{-- Confirm Password --}}
                    <x-form.input type="password" name="password_confirmation" label="Confirm password" required />

                    {{-- Date of Birth --}}
                    <x-form.input type="date" name="dob" label="Please enter date of birth" required max="{{ now()->toDateString() }}" />

                    {{-- Submit --}}
                    <div class="d-grid my-3">
                        <button type="submit" class="btn btn-success bg-dark-green rounded-2 py-3 fw-bold">
                            SIGN UP
                        </button>
                    </div>

                    {{-- Login Link --}}
                    <p class="text-center small mb-0">
                        Already registered?
                        <a href="{{ route('login') }}" class="text-decoration-none fw-semibold" aria-label="Go to login page">
                            Login
                        </a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
