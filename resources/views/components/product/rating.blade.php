@props([
    'rating' => 0,
])

@php
    $formattedRating = fmod($rating, 1) === 0.0
        ? number_format($rating, 0)
        : number_format($rating, 1);

    $fullStars = floor($rating);
    $hasHalfStar = fmod($rating, 1) >= 0.25 && fmod($rating, 1) <= 0.75;
    $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
@endphp

<div class="d-flex justify-content-between align-items-center mb-3">
    <span class="text-muted small me-2">
        Rating {{ $formattedRating }}/5
    </span>
    <span class="text-warning">
        {{-- Full stars --}}
        @for ($i = 0; $i < $fullStars; $i++)
            <i class="fa-solid fa-star"></i>
        @endfor

        {{-- Half star --}}
        @if ($hasHalfStar)
            <i class="fa-solid fa-star-half-stroke"></i>
        @endif

        {{-- Empty stars --}}
        @for ($i = 0; $i < $emptyStars; $i++)
            <i class="fa-regular fa-star"></i>
        @endfor
    </span>
</div>
