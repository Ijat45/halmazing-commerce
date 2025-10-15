{{-- Promo Banner (3D Slider) --}}
<div class="position-relative mb-5">
    <div class="swiper promo-carousel">
        <div class="swiper-wrapper">
            <!-- Slide 1 -->
            <div class="swiper-slide">
                <div class="card text-white border-0 shadow-sm rounded-4 overflow-hidden w-100">
                    <div class="img-overlay"></div>
                    <img src="{{ asset('images/promos/first-promo.png') }}" class="card-img" alt="Promo Banner 1">
                    <div
                        class="card-img-overlay d-flex flex-column align-items-center justify-content-center p-4 text-center">
                        <h1 class="card-title mb-1 promo-text-on-image">20% Cashback!</h1>
                        <p class="lead mb-0 promo-text-on-image">Shop More, Save More</p>
                    </div>
                </div>
            </div>
            <!-- Slide 2 -->
            <div class="swiper-slide">
                <div class="card text-white border-0 shadow-sm rounded-4 overflow-hidden w-100">
                    <div class="img-overlay"></div>
                    <img src="{{ asset('images/promos/second-promo.png') }}" class="card-img" alt="Promo Banner 2">
                    <div
                        class="card-img-overlay d-flex flex-column align-items-center justify-content-center p-4 text-center">
                        <h2 class="card-title mb-0 promo-text-on-image">Get It Delivered Free, Today Only!</h2>
                    </div>
                </div>
            </div>
            <!-- Slide 3 -->
            <div class="swiper-slide">
                <div class="card text-white border-0 shadow-sm rounded-4 overflow-hidden w-100">
                    <div class="img-overlay"></div>
                    <img src="{{ asset('images/promos/third-promo.png') }}" class="card-img" alt="Promo Banner 3">
                    <div
                        class="card-img-overlay d-flex flex-column align-items-center justify-content-center p-4 text-center">
                        <h2 class="card-title mb-0 promo-text-on-image">Double the Joy: Buy 1, Get 1 Free!</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Search Bar Positioned Absolute --}}
    <div class="position-absolute w-100 px-3 d-md-none" style="bottom: -25px; left: 0; z-index: 10;">
        <div class="position-relative shadow-lg rounded-pill">
            <input type="text" class="form-control form-control-md rounded-pill pe-5 placeholder-sm"
                placeholder="Think your favourite food…" id="mobile-search">

            <!-- Clickable Search Button Inside -->
            <button type="button"
                class="btn position-absolute top-50 end-0 translate-middle-y me-2 p-0 border-0 bg-transparent"
                style="z-index: 10;">
                <i class="fa-solid fa-magnifying-glass fs-6 text-dark-green me-2"></i>
            </button>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Promo Banner Carousel
            new Swiper('.promo-carousel', {
                centeredSlides: true,
                slidesPerView: 1.2,
                spaceBetween: 16,
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                },
                initialSlide: 1,
                speed: 5000,

                // 👇 3D Coverflow Effect
                effect: 'coverflow',
                coverflowEffect: {
                    rotate: 0,
                    stretch: 0,
                    depth: 0,
                    modifier: 0.5,
                    slideShadows: false,
                }
            });
        });
    </script>
@endpush
