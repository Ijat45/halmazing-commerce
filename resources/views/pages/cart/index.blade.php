@extends('layouts.app')

@section('title', 'Cart')

@section('content')
    <div class="container my-4">
        <div class="row g-lg-5">
            {{-- Left Column: Cart Items --}}
            <div class="col-lg-7">
                <div class="row g-3">
                    @forelse ($cartItems as $item)
                        <div class="col-12">
                            <x-cart.item-card :item="$item" />
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info bg-light-green border-primary text-center rounded-4 py-4">
                                <h5 class="fw-bold mb-2">🛒 Your cart is empty</h5>
                                <p class="mb-3">Looks like you haven’t added anything yet.</p>
                                <a href="{{ route('pages.home.index') }}" class="btn btn-success bg-dark-green fw-semibold px-4">
                                    Start Shopping
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Right Column: Order Summary --}}
            <div class="col-lg-5">
                <x-cart.order-summary :subtotal="$subtotal" :discount-percent="$discountPercent" :discount-amount="$discountAmount" :tax-percent="$taxPercent" :tax-amount="$taxAmount"
                    :shipping="$shipping" :total="$total" />
            </div>
        </div>
    </div>

    {{-- Floating Checkout Bar --}}
    <x-cart.floating-checkout-bar :total="$total" />

    <div class="container">
        @include('pages.home.sections.top-sales', ['topSalesProducts' => $topSalesProducts])
        @include('pages.home.sections.new-listings', ['newListingProducts' => $newListingProducts])
    </div>
@endsection
