@props(['subtotal', 'discountPercent', 'discountAmount', 'taxPercent', 'taxAmount', 'shipping', 'total'])

<div class="mt-5 mt-lg-0 p-3 border rounded-4 bg-light-green border-primary shadow-sm">
    <div class="d-flex justify-content-between mb-1">
        <div>
            <h5 class="fw-bold text-dark mb-2">ORDER SUMMARY</h5>
            <p class="text-muted small mb-0">{{ now()->format('d F Y') }}</p>
        </div>
        <div>
            <a href="#" class="text-decoration-none  small"><i class="fa-solid fa-ellipsis"></i></a>
        </div>
    </div>
</div>
<div class="mt-3 p-3 border rounded-4 bg-light-green border-primary shadow-sm">
    <div class="d-flex justify-content-between mb-1">
        <span>Sub Total</span>
        <span class="fw-bold">@currency($subtotal)</span>
    </div>
    <div class="d-flex justify-content-between mb-1">
        <span>Discount ({{ $discountPercent }}%)</span>
        <span class="fw-bold text-danger">-@currency($discountAmount)</span>
    </div>
    <div class="d-flex justify-content-between mb-1">
        <span>Tax ({{ $taxPercent }}%)</span>
        <span class="fw-bold">@currency($taxAmount)</span>
    </div>
    <div class="d-flex justify-content-between mb-3">
        <span>Shipping</span>
        <span class="fw-bold">@currency($shipping)</span>
    </div>

    <hr class="border-2 text-primary">

    <div class="d-flex justify-content-between">
        <span class="fw-bold">Total</span>
        <span class="fw-bold text-dark-green">@currency($total)</span>
    </div>
</div>
