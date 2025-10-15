// Product Carousel Initialization
document.addEventListener("DOMContentLoaded", function () {
    // Product Carousels
    const swipers = document.querySelectorAll(".product-carousel");
    swipers.forEach(function (swiperElement) {
        new Swiper(swiperElement, {
            loop: false,
            spaceBetween: 16,
            speed: 600,

            // Default (mobile-first)
            slidesPerView: 2,
            freeMode: true, // 👈 allows free scrolling, not snapping per card

            navigation: {
                nextEl: swiperElement.querySelector(".swiper-button-next"),
                prevEl: swiperElement.querySelector(".swiper-button-prev"),
            },

            // Responsive breakpoints
            breakpoints: {
                576: {
                    slidesPerView: 2.4,
                },
                768: {
                    slidesPerView: 2.5,
                },
                992: {
                    slidesPerView: 3,
                },
                1200: {
                    slidesPerView: 4,
                },
            },
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const sizeSelectButton = document.getElementById("size-select-button");
    const selectedSizeInput = document.getElementById("selected-size");
    const sizeOptions = document.querySelectorAll(".size-option");

    if (sizeSelectButton && selectedSizeInput && sizeOptions.length > 0) {
        sizeOptions.forEach((option) => {
            option.addEventListener("click", function (e) {
                e.preventDefault();
                sizeSelectButton.textContent = this.textContent;
                selectedSizeInput.value = this.dataset.value;
            });
        });
    }
});
