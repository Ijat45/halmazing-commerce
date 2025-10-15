@props(['product', 'sizes' => [], 'price'])

<div class="mt-auto">
    <form action="{{ route('cart.add', $product->id) }}" method="POST">
        @csrf
        <input type="hidden" name="quantity" value="1">
        <div class="d-flex gap-3 align-items-center {{ !empty($sizes) ? 'justify-content-between' : 'justify-content-end' }}">
            {{-- Only show the dropdown if sizes are provided --}}
            @if (!empty($sizes))
                <div class="dropdown">
                    <button class="btn btn-outline-none border-0 p-0 dropdown-toggle" type="button" id="size-select-button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Select Size
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="size-select-button">
                        @foreach ($sizes as $size)
                            <li><a class="dropdown-item size-option" href="#"
                                    data-value="{{ $size }}">{{ $size }}</a></li>
                        @endforeach
                    </ul>
                    <input type="hidden" name="options[size]" id="selected-size">
                </div>
            @endif
    
            <button type="submit" class="btn btn-success btn-md rounded-pill d-flex justify-content-between align-items-center shadow-sm"
                style="background-color: var(--primary-green); border-color: var(--primary-green);">
                <span>Order Now <i class="fa-solid fa-arrow-right"></i></span>
            </button>
        </div>
    </form>
</div>
