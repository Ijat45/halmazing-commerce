@props(['total'])

<div class="checkout-bar">
    <div class="d-flex justify-content-center align-items-center">
        <p class="small lh-sm mb-0 me-3">Total Checkout: <br><span class="fw-bold fs-6 text-dark">@currency($total)</span></p>
        <a href="{{ route('checkout.index') }}" class="btn btn-success rounded-pill px-3 py-1 shadow-sm"
            style="background-color: var(--primary-green); border-color: var(--primary-green);">Checkout</a>
    </div>
</div>
