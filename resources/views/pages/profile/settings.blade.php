@extends('layouts.app')

@section('title', 'Profile')
@section('backUrl', route('pages.home.index'))

@section('content')
    <div class="container my-4">
        {{-- User Info Section --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            {{-- User Info Section --}}
            <div class="text-center mb-4">
                <div class="position-relative d-inline-block">
                    <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://i.pravatar.cc/150?u=' . auth()->id() }}"
                        alt="{{ auth()->user()->name }}" class="rounded-circle mb-2 object-fit-cover" width="120"
                        height="120" style="border: 4px solid #fff; box-shadow: 0 0 10px rgba(0,0,0,0.1);"
                        id="avatar-preview"
                        onerror="this.onerror=null;this.src='{{ asset('images/avatar_placeholder.png') }}';">

                    <label for="avatar"
                        class="position-absolute bottom-0 end-0 bg-success text-white rounded-circle d-flex justify-content-center align-items-center cursor-pointer"
                        style="width: 35px; height: 35px; text-decoration: none; border: 2px solid #fff; cursor: pointer;">
                        <i class="bi bi-pencil-fill"></i>
                    </label>
                    <input type="file" name="avatar" id="avatar" class="d-none" accept="image/*"
                        onchange="previewImage(this)">
                </div>

                <div class="mt-3 w-75 mx-auto">
                    <input type="text" name="name"
                        class="form-control text-center fw-bold fs-4 mb-1 border-0 bg-transparent"
                        value="{{ old('name', auth()->user()->name) }}" placeholder="Your Name">
                    <input type="email" name="email"
                        class="form-control text-center text-muted small border-0 bg-transparent"
                        value="{{ old('email', auth()->user()->email) }}" placeholder="your.email@example.com">
                </div>

                <div class="mt-2">
                    <button type="submit" class="btn btn-sm btn-primary rounded-pill px-4">Save Changes</button>
                </div>
            </div>
        </form>

        <script>
            function previewImage(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        document.getElementById('avatar-preview').src = e.target.result;
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            document.addEventListener('DOMContentLoaded', function () {
                const toggle = document.getElementById('dark_mode');
                const html = document.documentElement;

                // Set initial state based on current theme
                if (html.getAttribute('data-bs-theme') === 'dark') {
                    toggle.checked = true;
                }

                toggle.addEventListener('change', function () {
                    const theme = this.checked ? 'dark' : 'light';
                    html.setAttribute('data-bs-theme', theme);
                    localStorage.setItem('theme', theme);
                });
            });
        </script>

        {{-- General Settings Section --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-gray border-0 rounded-top-4 pt-3 px-4">
                <h6 class="text-muted fw-bold">GENERAL SETTINGS</h6>
            </div>
            <div class="list-group list-group-flush">
                <x-settings.item icon="moon-stars" label="Mode" :isToggle="true" toggleName="dark_mode"
                    :toggleChecked="false" {{-- You can bind this to a user preference --}} />
                <x-settings.item icon="key" label="Change Password" href="{{ route('password.edit') }}" />
                <x-settings.item icon="translate" label="Language" href="#" /> {{-- Link to language selection page --}}
            </div>
        </div>

        {{-- Information Section --}}
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-gray border-0 rounded-top-4 pt-3 px-4">
                <h6 class="text-muted fw-bold">INFORMATION</h6>
            </div>
            <div class="list-group list-group-flush">
                <x-settings.item icon="info-circle" label="About App" href="#" />
                <x-settings.item icon="file-earmark-text" label="Terms & Conditions" href="{{ route('legal.terms') }}" {{--
                    Link to terms and conditions page --}} />
                <x-settings.item icon="shield-check" label="Privacy Policy" href="{{ route('legal.privacy') }}" {{-- Link to
                    privacy policy page --}} />
            </div>
        </div>
    </div>

@endsection