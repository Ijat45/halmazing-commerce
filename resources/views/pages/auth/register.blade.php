@extends('layouts.app')

@section('title', 'Register')
@section('backUrl', route('pages.home.index'))

@section('content')
    <div class="container d-flex justify-content-center align-items-center min-vh-100 py-5">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            {{-- Logo Section --}}
            <div class="text-center mb-4">
                <img src="{{ asset('halmazing-logo.png') }}" alt="Halmazing Logo" class="img-fluid"
                    style="max-height: 80px;">
                <h4 class="fw-bold mt-3 text-dark-green">Create an Account</h4>
                <p class="text-muted small">Join our community today.</p>
            </div>

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4 p-md-5">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        {{-- Name --}}
                        <div class="mb-3">
                            <x-form.input name="name" label="Full Name" placeholder="Enter your full name" required
                                autofocus />
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <x-form.input type="email" name="email" label="Email Address" placeholder="name@example.com"
                                required />
                        </div>

                        {{-- Date of Birth --}}
                        <div class="mb-3">
                            <x-form.input type="date" name="dob" label="Date of Birth" required
                                max="{{ now()->toDateString() }}" />
                        </div>

                        <div class="row">
                            {{-- Password --}}
                            <div class="col-md-6 mb-3">
                                <x-form.input type="password" name="password" label="Password" placeholder="Min. 8 chars"
                                    required />
                            </div>

                            {{-- Confirm Password --}}
                            <div class="col-md-6 mb-3">
                                <x-form.input type="password" name="password_confirmation" label="Confirm Password"
                                    placeholder="Re-enter password" required />
                            </div>
                        </div>

                        <hr class="my-4 opacity-10">

                        {{-- Merchant Application --}}
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input cursor-pointer" type="checkbox" role="switch" value="1"
                                id="apply_merchant" name="apply_merchant">
                            <label class="form-check-label small fw-semibold cursor-pointer" for="apply_merchant">
                                I want to sell on Halmazing (Merchant Account)
                            </label>
                        </div>

                        <div id="merchant-fields" style="display: none;" class="mb-4 bg-light p-3 rounded-3">
                            <x-form.input name="business_name" label="Business Name (Optional)"
                                placeholder="e.g. Halal Delights Co." />
                        </div>

                        {{-- Terms and Conditions --}}
                        <div class="form-check mb-4">
                            <input class="form-check-input cursor-pointer" type="checkbox" value="" id="terms" name="terms"
                                required>
                            <label class="form-check-label small text-muted" for="terms">
                                I agree to the
                                <a href="{{ route('legal.terms') }}" target="_blank"
                                    class="text-decoration-none fw-bold text-dark-green">Terms & Conditions</a> and
                                <a href="{{ route('legal.privacy') }}" target="_blank"
                                    class="text-decoration-none fw-bold text-dark-green">Privacy Policy</a>.
                            </label>
                        </div>

                        {{-- Submit --}}
                        <div class="d-grid mb-4">
                            <button type="submit"
                                class="btn btn-primary bg-dark-green border-0 rounded-pill py-3 fw-bold text-uppercase shadow-sm hover-scale">
                                Create Account
                            </button>
                        </div>

                        {{-- Login Link --}}
                        <div class="text-center">
                            <p class="small text-muted mb-0">
                                Already have an account?
                                <a href="{{ route('login') }}" class="text-decoration-none fw-bold text-dark-green">
                                    Login here
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Footer Links --}}
            <div class="text-center mt-4">
                <small class="text-muted opacity-50">&copy; {{ date('Y') }} Halmazing Commerce</small>
            </div>
        </div>
    </div>

    {{-- Script for Merchant Toggle --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkbox = document.getElementById('apply_merchant');
            const fields = document.getElementById('merchant-fields');

            if (checkbox && fields) {
                function toggleFields() {
                    fields.style.display = checkbox.checked ? 'block' : 'none';
                    // Optional: Scroll to bottom if opening
                    if (checkbox.checked) fields.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }

                checkbox.addEventListener('change', toggleFields);
                // Run on load
                toggleFields();
            }
        });
    </script>
@endsection