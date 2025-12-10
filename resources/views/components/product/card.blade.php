@props(['product'])

@php
    $formattedRating = fmod($product->rating ?? 0, 1) === 0.0
        ? number_format($product->rating ?? 0, 0)
        : number_format($product->rating ?? 0, 1);
@endphp

<div class="card border-0 shadow-sm rounded-4 h-100">
    <a href="{{ route('products.show', $product->id) }}" class="stretched-link"></a>
    <div class="position-relative">
        <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" class="card-img-top rounded-4 product-card-img"
            alt="{{ $product->name }}">
        {{-- Rating Badge --}}
        <span class="badge bg-light-green text-dark-green position-absolute top-0 start-0 m-2 shadow-sm">
            <i class="fa-solid fa-star product-card-rating-icon"></i> {{ $formattedRating }}
        </span>

        {{-- Top Sales Badge --}}
        @if ($product->is_top_sale ?? false)
            <span class="fa-stack top-sales-badge m-2">
                <i class="fa-solid fa-certificate fa-stack-2x" style="font-size: 2.2rem; color: #dc3545;"></i>
                <i class="fa-solid fa-thumbs-up fa-stack-1x" style="font-size: 1rem; color: #ffffff;"></i>
            </span>
        @endif
    </div>
    <div class="card-body p-2 position-relative">
        <div class="d-flex justify-content-between align-items-end">
            <div>
                <p class="card-text text-muted mb-1" style="font-size: 0.8rem;">{{ $product->category ?? 'N/A' }}</p>
                <h6 class="card-title fw-bold mb-0 me-2" style="font-size: 0.8rem;">{{ $product->name }}</h6>
            </div>
            <p class="fw-bold mb-0 flex-shrink-0" style="font-size: 0.8rem;">@currency($product->price)</p>
        </div>
        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="product-card-add-form">
            @csrf
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="btn btn-sm rounded-circle product-card-add-button m-2"
                aria-label="Add to cart">
                <i class="fa-solid fa-plus"></i>
            </button>
        </form>
    </div>
</div>