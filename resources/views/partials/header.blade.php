@props(['title' => 'Page Title'])

@php
    // Determine a safe URL to go back to.
    // If the previous URL is the same as the current one (e.g., after a redirect),
    // or if there's no previous URL, fall back to the home page.
    $backUrl = url()->previous() !== url()->current() ? url()->previous() : route('pages.home.index');
@endphp

<header class="allpage-header">
    <a href="{{ $backUrl }}" class="allpage-header-back text-dark-green">&#x276E;</a>
    <h1 class="allpage-header-title">{{ $title }}</h1>
</header>
