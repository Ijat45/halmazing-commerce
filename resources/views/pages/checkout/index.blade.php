@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <div class="container my-4">
        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <div class="row g-4">
                {{-- Left Column: Order Summary --}}
                <div class="col-lg-7">
                    <div class="card rounded-4 bg-light-green border-primary">
                        <div class="card-body p-4">
                            <h4 class="fw-bold mb-3">Order Summary</h4>

                            {{-- Cart Items --}}
                            @foreach ($cartItems as $item)
                                <div class="d-flex align-items-center mb-3 pb-3 border-bottom border-primary">
                                    <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" class="rounded-3 me-3"
                                        style="width: 60px; height: 60px; object-fit: cover;">
                                    <div class="flex-grow-1">
                                        <h6 class="fw-semibold mb-1">{{ $item->name }}</h6>
                                        <small class="text-muted">Qty: {{ $item->quantity }}</small>
                                    </div>
                                    <div class="text-end">
                                        <div class="fw-bold">@currency($item->total)</div>
                                    </div>
                                </div>
                            @endforeach

                            {{-- Order Totals --}}
                            <div class="mt-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal</span>
                                    <span>@currency($subtotal)</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Discount ({{ $discountPercent }}%)</span>
                                    <span class="text-danger">-@currency($discountAmount)</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Tax ({{ $taxPercent }}%)</span>
                                    <span>@currency($taxAmount)</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Shipping</span>
                                    <span>@currency($shipping)</span>
                                </div>
                                <hr class="my-3">
                                <div class="d-flex justify-content-between fs-5 fw-bold">
                                    <span>Total</span>
                                    <span>@currency($total)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Column: Payment & Shipping Info --}}
                <div class="col-lg-5">
                    <div class="card rounded-4 bg-light-green border-primary mb-4">
                        <div class="card-body p-4">
                            <h4 class="fw-bold mb-3">Shipping Information</h4>

                            <div class="mb-3">
                                <label for="shipping_name" class="form-label fw-semibold">Full Name</label>
                                <input type="text" class="form-control rounded-3" id="shipping_name" name="shipping_name"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="shipping_address" class="form-label fw-semibold">Address</label>
                                <textarea class="form-control rounded-3" id="shipping_address" name="shipping_address" rows="3" required></textarea>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="shipping_city" class="form-label fw-semibold">City</label>
                                        <input type="text" class="form-control rounded-3" id="shipping_city"
                                            name="shipping_city" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="shipping_zip" class="form-label fw-semibold">ZIP Code</label>
                                        <input type="text" class="form-control rounded-3" id="shipping_zip"
                                            name="shipping_zip" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card rounded-4 bg-light-green border-primary mb-4">
                        <div class="card-body p-4">
                            <h4 class="fw-bold mb-3">Payment Method</h4>

                            {{-- Cash on Delivery --}}
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="payment_method" id="cod"
                                    value="cod" checked>
                                <label class="form-check-label fw-semibold" for="cod">
                                    Cash on Delivery
                                </label>
                            </div>

                            {{-- FPX (Malaysia Online Banking) --}}
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="payment_method" id="fpx"
                                    value="fpx">
                                <label class="form-check-label fw-semibold" for="fpx">
                                    FPX Online Banking <span class="text-muted">(Malaysia)</span>
                                </label>
                            </div>

                            {{-- Credit/Debit Card --}}
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="card"
                                    value="card" disabled>
                                <label class="form-check-label text-muted" for="card">
                                    Credit/Debit Card (Coming Soon)
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-lg rounded-3 fw-semibold">
                            Place Order
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
