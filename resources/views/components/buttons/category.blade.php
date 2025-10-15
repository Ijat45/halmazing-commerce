<a href="{{ route('products.index', ['category' => $label]) }}"
    class="btn w-100 h-100 d-flex flex-column justify-content-center align-items-center p-2 rounded-4 border-0">
    <div class="d-flex justify-content-center align-items-center rounded-3 mb-1"
        style="width: 50px; height: 50px; background-color: #e9f7ea;">
        <i class="{{ $icon }} fs-3" style="color: var(--primary-green);"></i>
    </div>
    <small class="text-muted">{{ $label }}</small>
</a>
