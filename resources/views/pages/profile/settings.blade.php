@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <div class="container my-4">
        {{-- User Info Section --}}
        <div class="text-center mb-4">
            <div class="position-relative d-inline-block">
                <img src="https://i.pravatar.cc/150?u={{ auth()->id() }}" alt="{{ auth()->user()->name }}"
                    class="rounded-circle mb-2" width="120" height="120"
                    style="border: 4px solid #fff; box-shadow: 0 0 10px rgba(0,0,0,0.1);"
                    onerror="this.onerror=null;this.src='{{ asset('images/avatar_placeholder.png') }}';">
                <a href="#" class="position-absolute bottom-0 end-0 bg-success text-white rounded-circle d-flex justify-content-center align-items-center"
                    style="width: 35px; height: 35px; text-decoration: none; border: 2px solid #fff;"
                    aria-label="Edit Avatar">
                    <i class="bi bi-pencil-fill"></i>
                </a>
            </div>
            <h4 class="fw-bold mb-0">{{ auth()->user()->name }}</h4>
            <p class="text-muted">{{ auth()->user()->email }}</p>
        </div>

        {{-- General Settings Section --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-gray border-0 rounded-top-4 pt-3 px-4">
                <h6 class="text-muted fw-bold">GENERAL SETTINGS</h6>
            </div>
            <div class="list-group list-group-flush">
                <x-settings.item
                    icon="moon-stars"
                    label="Mode"
                    :isToggle="true"
                    toggleName="dark_mode"
                    :toggleChecked="false" {{-- You can bind this to a user preference --}}
                />
                <x-settings.item
                    icon="key"
                    label="Change Password"
                    href="#" {{-- Link to password change page --}}
                />
                <x-settings.item
                    icon="translate"
                    label="Language"
                    href="#"
                /> {{-- Link to language selection page --}}
            </div>
        </div>

        {{-- Information Section --}}
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-gray border-0 rounded-top-4 pt-3 px-4">
                <h6 class="text-muted fw-bold">INFORMATION</h6>
            </div>
            <div class="list-group list-group-flush">
                <x-settings.item
                    icon="info-circle"
                    label="About App"
                    href="#"
                />
                <x-settings.item
                    icon="file-earmark-text"
                    label="Terms & Conditions"
                    href="#" {{-- Link to terms and conditions page --}}
                />
                <x-settings.item
                    icon="shield-check"
                    label="Privacy Policy"
                    href="#" {{-- Link to privacy policy page --}}
                />
            </div>
        </div>
    </div>

@endsection