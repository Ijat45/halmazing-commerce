@props(['item'])

@php
    $rating = $item->product->rating ?? 0;
    $formattedRating = fmod($rating, 1) === 0.0 ? number_format($rating, 0) : number_format($rating, 1);
    $fullStars = floor($rating);
    $decimalPart = fmod($rating, 1);
    $hasHalfStar = $decimalPart >= 0.25 && $decimalPart <= 0.75;
    $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
@endphp

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-3">
        <div class="d-flex">
            {{-- Product Image --}}
            <a href="{{ route('products.show', $item->product_id) }}">
                <div class="rounded-3 me-3 flex-shrink-0 bg-cover bg-center"
                    style="width: 80px; height: 80px; background-image: url('{{ asset($item->image) }}');">
                </div>
            </a>

            {{-- Product Info & Actions --}}
            <div class="flex-grow-1">
                <div class="d-flex justify-content-between">
                    {{-- Left: Product Name + Price --}}
                    <div class="me-3">
                        <a href="{{ route('products.show', $item->product_id) }}" class="text-decoration-none text-dark">
                            <h6 class="fw-bold text-uppercase mb-1">{{ $item->name }}</h6>
                        </a>
                        <p class="text-muted small mb-2 text-truncate">
                            {{ \Illuminate\Support\Str::words($item->product->description ?? '', 3, '...') }}
                        </p>
                        <span class="fw-bold text-light bg-dark-green px-2 py-1 rounded-3 fs-6">
                            RM{{ number_format($item->price, 2) }}
                        </span>
                    </div>

                    {{-- Right: Remove Button --}}
                    <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm text-danger" aria-label="Remove item">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <hr class="my-2">

        {{-- Bottom: Rating & Quantity Controls --}}
        <div class="d-flex justify-content-between align-items-center">
            {{-- Rating --}}
            <div class="text-warning icon-straight-line small">
                @for ($i = 0; $i < $fullStars; $i++)
                    <i class="fa-solid fa-star"></i>
                @endfor
                @if ($hasHalfStar)
                    <i class="fa-solid fa-star-half-stroke"></i>
                @endif
                @for ($i = 0; $i < $emptyStars; $i++)
                    <i class="fa-regular fa-star"></i>
                @endfor
                <span class="ms-1 text-muted">({{ $formattedRating }})</span>
            </div>

            {{-- Quantity Controls --}}
            <div class="d-flex align-items-center">
                {{-- Decrease Quantity --}}
                <form
                    action="{{ $item->quantity > 1 ? route('cart.update', $item->id) : route('cart.destroy', $item->id) }}"
                    method="POST">
                    @csrf
                    @if ($item->quantity > 1)
                        @method('PATCH')
                        <input type="hidden" name="quantity" value="{{ $item->quantity - 1 }}">
                    @else
                        @method('DELETE')
                    @endif
                    <button type="submit"
                        class="btn btn-sm btn-outline-secondary rounded-circle d-flex justify-content-center align-items-center"
                        style="width: 28px; height: 28px;" aria-label="Decrease quantity">
                        <i class="fa-solid {{ $item->quantity > 1 ? 'fa-minus' : 'fa-trash-can' }}"></i>
                    </button>
                </form>

                <span class="mx-2 fw-bold">{{ $item->quantity }}</span>

                {{-- Increase Quantity --}}
                <form action="{{ route('cart.update', $item->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="quantity" value="{{ $item->quantity + 1 }}">
                    <button type="submit"
                        class="btn btn-sm btn-outline-secondary rounded-circle d-flex justify-content-center align-items-center"
                        style="width: 28px; height: 28px;" aria-label="Increase quantity">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
