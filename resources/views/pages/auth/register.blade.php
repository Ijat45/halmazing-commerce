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

                    {{-- Merchant Application --}}
                    <div class="form-check my-3">
                        <input class="form-check-input" type="checkbox" value="1" id="apply_merchant" name="apply_merchant">
                        <label class="form-check-label small" for="apply_merchant">
                            I want to apply to sell on this platform (Merchant account)
                        </label>
                    </div>

                    <div id="merchant-fields" style="display: none;">
                        <x-form.input name="business_name" label="Business name (optional)" />
                    </div>

                    {{-- Terms and Conditions Checkbox --}}
                    <div class="form-check my-3">
                        <input class="form-check-input" type="checkbox" value="" id="terms" name="terms" required>
                        <label class="form-check-label small" for="terms">
                            I agree to the
                            <a href="{{ route('legal.terms') }}" target="_blank" class="text-decoration-none fw-semibold">Terms and Conditions</a> and
                            <a href="{{ route('legal.privacy') }}" target="_blank" class="text-decoration-none fw-semibold">Privacy Policy</a>.
                        </label>
                    </div>

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
                <script>
                    (function () {
                        const checkbox = document.getElementById('apply_merchant');
                        const fields = document.getElementById('merchant-fields');
                        if (!checkbox) return;
                        checkbox.addEventListener('change', function () {
                            fields.style.display = checkbox.checked ? 'block' : 'none';
                        });
                        // On load (in case of validation errors)
                        if (checkbox.checked) fields.style.display = 'block';
                    })();
                </script>
            </div>
        </div>
    </div>
</div>
@endsection
