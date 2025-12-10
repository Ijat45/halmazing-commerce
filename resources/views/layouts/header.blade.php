<header class="header p-3 shadow-sm sticky-top">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">

            {{-- Left: Logo + Location --}}
            <div class="d-flex align-items-center">
                <a href="{{ route('pages.home.index') }}"
                    class="text-decoration-none text-dark fw-bold me-3 d-flex align-items-center">
                    @if (file_exists(public_path('halmazing-logo.png')))
                        <img src="{{ asset('halmazing-logo.png') }}?v=3" alt="{{ config('app.name', 'Halmazing') }}"
                            height="40">
                    @else
                        <span class="fs-4">{{ config('app.name', 'Halmazing') }}</span>
                    @endif
                </a>

                {{-- Location Selector --}}
                <div class="d-flex align-items-center" id="location-selector">
                    <div class="rounded-circle bg-light-green text-dark-green me-2 d-flex justify-content-center align-items-center"
                        style="width: 25px; height: 25px;">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <div class="lh-1">
                        <small class="text-muted" style="font-size: 0.75rem;">Location</small>
                        <a href="#" class="d-block text-decoration-none lh-1" id="location-button">
                            <span class="fw-bold" style="font-size: 0.8rem;">{{ session('location_name', 'Set Location') }}</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Center: Search Bar (Desktop Only) --}}
            <div class="mx-4 w-50 d-none d-md-block">
                <form action="{{ route('products.index') }}" method="GET">
                    <div class="position-relative">
                        <input type="search" name="q" class="form-control rounded-pill pe-5 placeholder-sm"
                            placeholder="Think your favourite food…" id="desktop-search" value="{{ request('q') }}">
                        <button type="submit"
                            class="btn position-absolute top-50 end-0 translate-middle-y me-2 p-0 border-0 bg-transparent"
                            style="z-index: 10;" aria-label="Search">
                            <i class="fa-solid fa-magnifying-glass fs-5 text-dark-green me-2"></i>
                        </button>
                    </div>
                </form>
            </div>

            {{-- Right: User --}}
            <div class="d-flex align-items-center">
                @auth
                    {{-- Authenticated User Menu --}}
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-dark text-decoration-none" id="userDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://i.pravatar.cc/150?u={{ auth()->id() }}" alt="{{ auth()->user()->name }}"
                                class="rounded-circle me-2" width="40" height="40"
                                onerror="this.onerror=null;this.src='{{ asset('images/avatar_placeholder.png') }}';">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile.settings') }}">Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                        Logout
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    {{-- Guest User --}}
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-dark text-decoration-none"
                            id="guestDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('images/avatar_placeholder.png') }}" alt="Guest Avatar"
                                class="rounded-circle" width="40" height="40">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="guestDropdown">
                            <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>
                            <li><a class="dropdown-item" href="{{ route('register') }}">Register</a></li>
                        </ul>
                    </div>
                @endauth
            </div>

        </div>
    </div>
</header>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const locationButton = document.getElementById('location-button');
    if (locationButton) {
        locationButton.addEventListener('click', function(event) {
            event.preventDefault();
            
            if (!navigator.geolocation) {
                alert('Geolocation is not supported by your browser.');
                return;
            }

            const originalText = this.innerHTML;
            this.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
            this.style.pointerEvents = 'none';

            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const { latitude, longitude } = position.coords;
                    sendLocationToServer(latitude, longitude);
                },
                (error) => {
                    console.error('Geolocation error:', error);
                    alert('Unable to retrieve your location. Please ensure location services are enabled.');
                    this.innerHTML = originalText;
                    this.style.pointerEvents = 'auto';
                }
            );
        });
    }

    function sendLocationToServer(latitude, longitude) {
        const locationButton = document.getElementById('location-button');
        const originalText = locationButton.innerHTML;

        fetch('{{ route("location.change") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ latitude, longitude })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                throw new Error(data.message || 'Failed to set location.');
            }
        })
        .catch(error => {
            console.error('Error setting location:', error);
            alert('There was an error setting your location.');
            locationButton.innerHTML = originalText;
            locationButton.style.pointerEvents = 'auto';
        });
    }
});
</script>
@endpush
