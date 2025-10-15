@extends('layouts.app')

@section('title', 'Order Successful')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="text-center">
                    {{-- Success Icon --}}
                    <div class="mb-4">
                        <div class="bg-success rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 100px; height: 100px;">
                            <i class="fas fa-check text-white" style="font-size: 3rem;"></i>
                        </div>
                    </div>

                    {{-- Success Message --}}
                    <h1 class="fw-bold text-success mb-3">Order Placed Successfully!</h1>
                    <p class="fs-5 text-muted mb-4">
                        Thank you for your order. We've received your order and will begin processing it soon.
                    </p>

                    {{-- Order Details Card --}}
                    <div class="card rounded-4 border-light-subtle mb-4">
                        <div class="card-body p-4">
                            <h4 class="fw-bold mb-3">What's Next?</h4>
                            <div class="row text-start">
                                <div class="col-12 mb-3">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center me-3" 
                                             style="width: 40px; height: 40px; min-width: 40px;">
                                            <i class="fas fa-envelope text-white"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold mb-1">Order Confirmation</h6>
                                            <p class="text-muted mb-0 small">You'll receive an email confirmation shortly with order details.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-warning rounded-circle d-inline-flex align-items-center justify-content-center me-3" 
                                             style="width: 40px; height: 40px; min-width: 40px;">
                                            <i class="fas fa-clock text-white"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold mb-1">Processing</h6>
                                            <p class="text-muted mb-0 small">We'll prepare your order for delivery within 1-2 business days.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-success rounded-circle d-inline-flex align-items-center justify-content-center me-3" 
                                             style="width: 40px; height: 40px; min-width: 40px;">
                                            <i class="fas fa-truck text-white"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold mb-1">Delivery</h6>
                                            <p class="text-muted mb-0 small">Your order will be delivered to your specified address within 3-5 business days.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                        @auth
                            <a href="{{ route('orders.index') }}" class="btn btn-outline-primary rounded-3 px-4">
                                <i class="fas fa-list-alt me-2"></i>View My Orders
                            </a>
                        @endauth
                        <a href="{{ route('pages.home.index') }}" class="btn btn-success rounded-3 px-4">
                            <i class="fas fa-home me-2"></i>Continue Shopping
                        </a>
                    </div>

                    {{-- Support Message --}}
                    <div class="mt-5 pt-4 border-top">
                        <p class="text-muted">
                            <i class="fas fa-question-circle me-2"></i>
                            Need help? Contact our support team at 
                            <a href="mailto:support@halmazing.com" class="text-decoration-none">support@halmazing.com</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection