{{-- New Listing Section --}}
<div>
    <h4 class="fw-bold">New Listing</h4>
    <!-- Swiper -->
    <div class="swiper product-carousel">
        <div class="swiper-wrapper">
            @foreach ($newListingProducts ?? [] as $product)
                <div class="swiper-slide">
                    <x-product.card :product="$product" />
                </div>
            @endforeach
            {{-- View More Card --}}
            <div class="swiper-slide">
                <a href="#" class="card d-flex justify-content-center align-items-center text-decoration-none h-100 text-center view-more-card">
                    <div class="p-3">
                        <i class="fa-solid fa-circle-arrow-right fs-1"></i>
                        <p class="fw-bold mt-2 mb-0">View More</p>
                    </div>
                </a>
            </div>
        </div>
        <!-- Add Navigation -->
        <div class="swiper-button-next d-none d-lg-block"></div>
        <div class="swiper-button-prev d-none d-lg-block"></div>
    </div>
</div>