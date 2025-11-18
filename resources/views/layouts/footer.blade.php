<footer class="footer">
    <div class="footer-top container">
        <div class="row gy-5">

            <!-- Customer Service -->
            <div class="col-6 col-lg-3">
                <p class="footer-title">Customer Service</p>
                <ul class="footer-list">
                    <li><a href="#">Help Centre</a></li>
                    <li><a href="#">How To Buy</a></li>
                    <li><a href="#">Return & Refund</a></li>
                    <li><a href="#">Contact Us</a></li>
                </ul>
            </div>

            <!-- About Halmazing -->
            <div class="col-6 col-lg-3">
                <p class="footer-title">About Halmazing</p>
                <ul class="footer-list">
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Halmazing Careers</a></li>
                    <li><a href="#">Policies</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>

            <!-- Payment -->
            <div class="col-6 col-lg-2">
                <p class="footer-title">Payment</p>
                <ul class="footer-icons footer-icons-payments">
                    <li><img src="{{ asset('images/logos/payment-visa.png') }}" alt="Visa"></li>
                    <li><img src="{{ asset('images/logos/payment-mastercard.png') }}" alt="Mastercard"></li>
                </ul>
            </div>

            <!-- Logistics -->
            <div class="col-6 col-lg-2">
                <p class="footer-title">Logistics</p>
                <ul class="footer-icons footer-icons-logistics">
                    <li><img src="{{ asset('images/logos/logistics-jnt.png') }}" alt="J&T Express"></li>
                    <li><img src="{{ asset('images/logos/logistics-ninjavan.png') }}" alt="Ninja Van"></li>
                </ul>
            </div>

            <!-- Follow Us -->
            <div class="col-12 col-lg-2">
                <p class="footer-title">Follow Us</p>
                <ul class="footer-icons footer-icons-social">
                    <li><a href="#"><i class="fab fa-facebook-square"></i></a></li>
                    <li><a href="#"><i class="fab fa-instagram-square"></i></a></li>
                    <li><a href="#"><i class="fab fa-linkedin"></i></a></li>
                </ul>
            </div>

        </div>
    </div>

    <div class="footer-bottom">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
            <span>&copy; {{ date('Y') }} Halmazing. All Rights Reserved.</span>

            <div class="footer-region">
                <span>Country & Region:</span>
                <a href="#">Malaysia</a>
            </div>
        </div>
    </div>
</footer>
