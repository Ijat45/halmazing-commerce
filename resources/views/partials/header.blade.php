@props(['title' => 'Page Title', 'backUrl' => null])

@php
    if (!$backUrl) {
        $previous = url()->previous();
        $current = url()->current();

        // 1. If previous is same as current (loop), default to Home
        // 2. If valid previous exists, use it
        // 3. Otherwise Home
        if ($previous !== $current && $previous !== url('/')) {
            $backUrl = $previous;
        } else {
            $backUrl = route('pages.home.index');
        }
    }
@endphp

<header class="allpage-header">
    <a href="{{ $backUrl }}" class="allpage-header-back text-dark-green">
        <i class="fa-solid fa-chevron-left"></i>
    </a>
    <h1 class="allpage-header-title">{{ $title }}</h1>
</header>
