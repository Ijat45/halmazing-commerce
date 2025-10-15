{{-- Example Laravel Blade View showing Currency Usage --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Currency Example</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1>Currency Detection & Conversion Example</h1>
        
        {{-- Currency Selector --}}
        <div class="row mb-4">
            <div class="col-md-6">
                <h3>Currency Selector</h3>
                <p>Current currency: <strong>@currentCurrency()</strong> (@currencySymbol())</p>
                @currencySelect
            </div>
        </div>
        
        {{-- Product Price Examples --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <h3>Product Prices</h3>
                <div class="row">
                    {{-- Sample products with USD prices that get auto-converted --}}
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Laptop</h5>
                                <p class="card-text">High-performance laptop for professionals</p>
                                <p class="text-muted">Original Price (USD): $999.00</p>
                                <h6 class="text-primary">Your Price: @currency(999)</h6>
                                <small class="text-muted">Automatically converted to @currentCurrency()</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Smartphone</h5>
                                <p class="card-text">Latest smartphone with advanced features</p>
                                <p class="text-muted">Original Price (USD): $599.00</p>
                                <h6 class="text-primary">Your Price: @currency(599)</h6>
                                <small class="text-muted">Automatically converted to @currentCurrency()</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Headphones</h5>
                                <p class="card-text">Noise-cancelling wireless headphones</p>
                                <p class="text-muted">Original Price (USD): $199.00</p>
                                <h6 class="text-primary">Your Price: @currency(199)</h6>
                                <small class="text-muted">Automatically converted to @currentCurrency()</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Using PHP Helper Functions (alternative to Blade directives) --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <h3>PHP Helper Functions Examples</h3>
                <div class="row">
                    <div class="col-md-6">
                        <h5>Price Conversion & Formatting</h5>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Convert $100 USD
                                <span class="badge bg-primary rounded-pill">{{ convert_and_format_price(100) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Convert $250 USD
                                <span class="badge bg-primary rounded-pill">{{ convert_and_format_price(250) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Convert $75.99 USD
                                <span class="badge bg-primary rounded-pill">{{ convert_and_format_price(75.99) }}</span>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="col-md-6">
                        <h5>Currency Information</h5>
                        <ul class="list-group">
                            <li class="list-group-item">Current Currency: <strong>{{ current_currency() }}</strong></li>
                            <li class="list-group-item">Currency Symbol: <strong>{{ currency_symbol() }}</strong></li>
                            <li class="list-group-item">Available Currencies: <strong>{{ count(available_currencies()) }}</strong></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Shopping Cart Example --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <h3>Shopping Cart Example</h3>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Your Cart</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Price (MYR)</th>
                                    <th>Price ({{ current_currency() }})</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Laptop</td>
                                    <td>1</td>
                                    <td>$999.00</td>
                                    <td>@currency(999)</td>
                                    <td>@currency(999)</td>
                                </tr>
                                <tr>
                                    <td>Smartphone</td>
                                    <td>2</td>
                                    <td>@currency(599) each</td>
                                    <td>@currency(599) each</td>
                                    <td>@currency(1198)</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="table-primary">
                                    <th colspan="4">Total</th>
                                    <th>@currency(2197)</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- API Testing Section --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <h3>API Testing</h3>
                <div class="row">
                    <div class="col-md-4">
                        <button class="btn btn-outline-primary" onclick="testCurrentCurrency()">Get Current Currency</button>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-outline-secondary" onclick="testAvailableCurrencies()">Get Available Currencies</button>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-outline-success" onclick="testConvertPrice()">Test Price Conversion</button>
                    </div>
                </div>
                <div class="mt-3">
                    <textarea id="api-results" class="form-control" rows="10" placeholder="API results will appear here..." readonly></textarea>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // API Testing Functions
        function testCurrentCurrency() {
            fetch('/api/currency/current')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('api-results').value = JSON.stringify(data, null, 2);
                })
                .catch(error => {
                    document.getElementById('api-results').value = 'Error: ' + error.message;
                });
        }
        
        function testAvailableCurrencies() {
            fetch('/api/currency/available')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('api-results').value = JSON.stringify(data, null, 2);
                })
                .catch(error => {
                    document.getElementById('api-results').value = 'Error: ' + error.message;
                });
        }
        
        function testConvertPrice() {
            const testData = {
                price: 100,
                to_currency: 'EUR'
            };
            
            fetch('/api/currency/convert', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(testData)
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('api-results').value = JSON.stringify(data, null, 2);
            })
            .catch(error => {
                document.getElementById('api-results').value = 'Error: ' + error.message;
            });
        }
        
        // Display current location info (for debugging)
        console.log('Current page loaded. Currency detection middleware should have run.');
        console.log('Current currency from session:', '{{ current_currency() }}');
    </script>
</body>
</html>