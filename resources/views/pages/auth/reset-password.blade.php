@extends('layouts.app')

@section('title', 'Reset Password')
@section('backUrl', route('login'))

@section('content')
    <div class="container d-flex flex-column justify-content-center align-items-center min-vh-100 py-4">
        <div class="text-center mb-4">
            <h1 class="fw-bold display-5 text-dark-green mb-0">Reset Password</h1>
            <p class="text-muted">Create a new password for your account.</p>
        </div>

        <div class="card border-0 shadow-lg rounded-4 w-100" style="max-width: 400px;">
            <div class="card-body p-4">
                <form action="{{ route('password.store') }}" method="POST">
                    @csrf
                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="mb-3">
                        <label for="email" class="form-label text-muted fw-bold small">Email Address</label>
                        <input type="email" class="form-control rounded-3 py-2 @error('email') is-invalid @enderror"
                            id="email" name="email" value="{{ old('email', $request->email) }}" required autofocus
                            placeholder="name@example.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label text-muted fw-bold small">New Password</label>
                        <input type="password" class="form-control rounded-3 py-2 @error('password') is-invalid @enderror"
                            id="password" name="password" required autocomplete="new-password"
                            placeholder="MIN. 8 CHARACTERS">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label text-muted fw-bold small">Confirm
                            Password</label>
                        <input type="password" class="form-control rounded-3 py-2" id="password_confirmation"
                            name="password_confirmation" required autocomplete="new-password"
                            placeholder="CONFIRM PASSWORD">
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-custom rounded-pill py-2 fw-bold">
                            Reset Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection