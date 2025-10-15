<div class="currency-selector dropdown {{ $attributes['class'] ?? '' }}"
     id="{{ $attributes['id'] ?? 'currency-selector-'.\Illuminate\Support\Str::random(8) }}">
    <button class="btn btn-outline-secondary dropdown-toggle" type="button" 
            data-bs-toggle="dropdown" aria-expanded="false"
            title="Select Currency">
        @currencySymbol() @currentCurrency()
    </button>
    <ul class="dropdown-menu">
        @foreach(available_currencies() as $code => $info)
            <li>
                <a class="dropdown-item currency-option {{ current_currency() === $code ? 'active' : '' }}" 
                   href="#" 
                   data-currency="{{ $code }}">
                    {{ $info['symbol'] }} {{ $code }} - {{ $info['name'] }}
                    @if(current_currency() === $code)
                        <i class="bi bi-check-circle-fill text-success ms-2"></i>
                    @endif
                </a>
            </li>
        @endforeach
    </ul>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Find all currency selectors on the page
    document.querySelectorAll('.currency-selector').forEach(selector => {
        const button = selector.querySelector('.dropdown-toggle');
        const options = selector.querySelectorAll('.currency-option');

        options.forEach(option => {
            option.addEventListener('click', function(event) {
                event.preventDefault();
                const currency = this.getAttribute('data-currency');
                const originalText = button.innerHTML;

                // Show loading state
                button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
                button.disabled = true;

                // Make AJAX request to change currency
                fetch('/change-currency', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ currency: currency })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Reload the page to update all prices
                        window.location.reload();
                    } else {
                        // If the server responds with success: false, throw an error to be caught
                        throw new Error(data.message || 'Server indicated failure.');
                    }
                })
                .catch(error => {
                    console.error('Currency change error:', error);
                    alert('An error occurred while changing the currency. Please try again.');
                })
                .finally(() => {
                    // This block will run whether the request succeeds or fails.
                    // It prevents the button from being stuck in a loading state.
                    button.innerHTML = originalText;
                    button.disabled = false;
                });
            });
        });
    });
});
</script>

<style>
.currency-selector .dropdown-menu {
    max-height: 300px;
    overflow-y: auto;
}

.currency-selector .dropdown-item.active {
    background-color: var(--bs-primary);
    color: white;
}

.currency-selector .dropdown-item:hover {
    background-color: var(--bs-light);
}

.currency-selector .dropdown-item.active:hover {
    background-color: var(--bs-primary);
}
</style>