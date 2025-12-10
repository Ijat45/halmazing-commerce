<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <script>
        (function () {
            const storedTheme = localStorage.getItem('theme');
            const getPreferredTheme = () => {
                if (storedTheme) {
                    return storedTheme;
                }
                return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            };
            document.documentElement.setAttribute('data-bs-theme', getPreferredTheme());
        })();
    </script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Halmazing Commerce</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:title" content="Halmazing Commerce">
    <meta property="og:description" content="">
    <meta property="og:image" content="{{ asset('halmazing-logo.png') }}?v=3">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="">
    <meta property="twitter:title" content="Halmazing Commerce">
    <meta property="twitter:description" content="">
    <meta property="twitter:image" content="{{ asset('halmazing-logo.png') }}?v=3">

    <!-- Favicon and App Icons -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=3">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}?v=3">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}?v=3">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}?v=3">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('android-chrome-192x192.png') }}?v=3">
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('android-chrome-512x512.png') }}?v=3">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}?v=3">
    <link rel="mask-icon" href="{{ asset('safari-pinned-tab.svg') }}?v=3" color="#0d6efd">
    <meta name="theme-color" content="#ffffff">
    <meta name="background-color" content="#ffffff">


    <!-- Manifest -->
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    <!-- Windows Tile / Edge Pinned Sites -->
    <meta name="msapplication-TileImage" content="{{ asset('halmazing-logo.png') }}?v=3">
    <meta name="msapplication-TileColor" content="#0d6efd">
    <meta name="theme-color" content="#0d6efd">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Swiper.js CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    {{-- Vite for custom CSS/JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Custom CSS --}}
    @stack('styles')
    @yield('styles')
</head>

<body>
    @if (!request()->routeIs('pages.home.index', 'products.index', 'products.show', 'login', 'register'))
        @include('partials.header', [
            'title' => View::hasSection('title') ? trim(View::getSection('title')) : 'Page Title',
            'backUrl' => View::hasSection('backUrl') ? trim(View::getSection('backUrl')) : null,
        ])
    @endif

    <main>
        @yield('content')
    </main>
    @if (!request()->routeIs('cart.index', 'login', 'register'))
        @include('layouts.bottom-nav')
    @endif

    @include('partials.category-modal')
    @if (!request()->routeIs('login', 'register'))
        @include('layouts.footer')
    @endif

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <!-- Swiper.js JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    @stack('scripts')
    @yield('scripts')

    <!-- Custom Share Button Script -->
     <script>
        document.addEventListener("DOMContentLoaded", function() {
            const shareButton = document.getElementById("share-button");
            if (!shareButton) return;

            // Initialize Bootstrap Tooltip
            const tooltip = new bootstrap.Tooltip(shareButton);

            shareButton.addEventListener('click', async () => {
                const shareData = {
                    title: document.title,
                    text: `Check out this: ${document.title}`,
                    url: window.location.href
                };

                // --- Always copy to clipboard ---
                try {
                    await navigator.clipboard.writeText(window.location.href);

                    // Update tooltip to show "Copied!"
                    tooltip.setContent({
                        '.tooltip-inner': 'Copied!'
                    });
                    tooltip.show();

                    // Change icon to a checkmark
                    const iconWrapper = shareButton.querySelector('.share-icon-wrapper');
                    const originalIcon = iconWrapper.innerHTML;
                    iconWrapper.innerHTML = '<i class="fa-solid fa-check text-success"></i>';

                    // Revert after delay
                    setTimeout(() => {
                        tooltip.hide();
                        iconWrapper.innerHTML = originalIcon;
                        tooltip.setContent({
                            '.tooltip-inner': 'Copy link'
                        });
                    }, 2000);

                } catch (err) {
                    console.error('Failed to copy: ', err);
                    alert('Failed to copy link.');
                }

                // --- Optional: Web Share API (mobile-friendly) ---
                if (navigator.share) {
                    try {
                        await navigator.share(shareData);
                        console.log('Shared successfully');
                    } catch (err) {
                        console.error('Share failed:', err.message);
                    }
                }

                // --- Call your API after copy/share ---
                try {
                    await fetch('/api/share', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .content // if using Laravel
                        },
                        body: JSON.stringify({
                            url: window.location.href,
                            title: document.title
                        })
                    });
                    console.log('API called successfully');
                } catch (err) {
                    console.error('API call failed:', err);
                }
            });
        });
    </script>
</body>
</html>
