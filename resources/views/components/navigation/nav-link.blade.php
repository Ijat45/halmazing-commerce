@props(['route', 'iconActive', 'iconInactive', 'label', 'params' => []]) 

@php
    $isUrl = filter_var($route, FILTER_VALIDATE_URL);
    $baseHref = $isUrl || $route === '#' ? $route : route($route);

    $queryString = http_build_query($params);

    $href = $baseHref . ($queryString ? '?' . $queryString : '');
@endphp

<div class="col">
    <a href="{{ $href }}" class="nav-link @if(request()->fullUrlIs($href) || (!$isUrl && Route::is($route))) active @endif">
        <i class="{{ $iconActive }} icon-active fs-5"></i>
        <i class="{{ $iconInactive }} icon-inactive fs-5"></i>
        <span class="nav-text">{{ $label }}</span>
    </a>
</div>