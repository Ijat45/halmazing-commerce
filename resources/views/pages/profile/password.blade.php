@extends('layouts.app')

@section('title', 'Change Password')
@section('backUrl', route('profile.settings'))

@section('content')
    <div class="container my-4">
        <div class="d-flex align-items-center mb-4">
            <h4 class="fw-bold mb-0">Change Password</h4>
        </div>

        @if (session('status') === 'password-updated')
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Password updated successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="current_password" class="form-label text-muted fw-bold small">Current Password</label>
                        <input type="password"
                            class="form-control rounded-3 py-2 @error('current_password') is-invalid @enderror"
                            id="current_password" name="current_password" required placeholder="Enter current password">
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label text-muted fw-bold small">New Password</label>
                        <input type="password" class="form-control rounded-3 py-2 @error('password') is-invalid @enderror"
                            id="password" name="password" required autocomplete="new-password"
                            placeholder="Enter new password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label text-muted fw-bold small">Confirm New
                            Password</label>
                        <input type="password" class="form-control rounded-3 py-2" id="password_confirmation"
                            name="password_confirmation" required autocomplete="new-password"
                            placeholder="Confirm new password">
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-custom rounded-pill py-2 fw-bold">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection