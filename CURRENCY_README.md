# IP-Based Currency Detection System for Laravel E-commerce

This implementation provides automatic currency detection based on users' IP addresses and dynamic price conversion for your Laravel e-commerce website.

## ✅ Features Implemented

- **Automatic IP Geolocation**: Uses ip-api.com to detect user's country
- **Country-to-Currency Mapping**: Maps 50+ countries to their primary currencies  
- **Session-based Currency Storage**: Stores detected currency in user session
- **Dynamic Price Conversion**: Converts USD prices to user's local currency
- **Manual Currency Switching**: Users can manually change currency via dropdown
- **Caching System**: Caches API responses to avoid rate limits
- **33+ Supported Currencies**: Including MYR, USD, EUR, JPY, GBP, etc.
- **Blade Directives**: Easy-to-use directives for price display
- **Helper Functions**: PHP helper functions for programmatic access
- **RESTful API**: JSON API endpoints for frontend integration

## 🏗️ Architecture

### Core Components

1. **CurrencyService** (`app/Services/CurrencyService.php`)
   - Handles IP geolocation via ip-api.com
   - Manages currency detection and conversion
   - Provides caching and error handling

2. **DetectCurrency Middleware** (`app/Http/Middleware/DetectCurrency.php`)
   - Automatically detects currency on first visit
   - Runs on all web requests (except API/admin routes)
   - Stores results in session

3. **CurrencyController** (`app/Http/Controllers/CurrencyController.php`)
   - Handles manual currency changes
   - Provides API endpoints for frontend integration

4. **Configuration** (`config/currency.php`)
   - Country-to-currency mappings
   - Exchange rates (update with live rates in production)
   - API settings and cache configuration

## 🚀 Quick Start

### 1. Auto-Detection is Already Active

The middleware automatically detects currency when users first visit your site. No setup required!

### 2. Display Prices in Views

Use Blade directives to show converted prices:

```blade
{{-- Convert USD price and display with currency symbol --}}
<span class="price">@currency(99.99)</span>
{{-- Output: $99.99 (USD), RM468.00 (MYR), ¥14,950 (JPY) --}}

{{-- Show current currency info --}}
<p>Currency: @currentCurrency() (@currencySymbol())</p>
{{-- Output: Currency: MYR (RM) --}}
```

### 3. Add Currency Selector

Include currency selector in your layout:

```blade
{{-- Add to header/navbar --}}
@currencySelect
```

### 4. Update Product Models

Ensure your product prices are stored in USD (base currency) in the database:

```php
// In your Product model or view
public function getFormattedPriceAttribute()
{
    return convert_and_format_price($this->price_usd);
}
```

## 📖 Usage Examples

### Blade Directives

```blade
{{-- Price conversion --}}
@currency(199.99)           {{-- Convert $199.99 USD to user's currency --}}
@price(150.50)             {{-- Format 150.50 in current currency --}}
@currencySymbol()          {{-- Display current currency symbol --}}
@currentCurrency()         {{-- Display current currency code --}}
@currencySelect            {{-- Show currency dropdown selector --}}
```

### PHP Helper Functions

```php
// In controllers or anywhere in PHP
convert_and_format_price(99.99);    // Returns: "RM468.00" for MYR
current_currency();                   // Returns: "MYR"  
currency_symbol();                    // Returns: "RM"
convert_price(100, 'JPY');           // Returns: 14950
format_price(468, 'MYR');            // Returns: "RM468.00"
```

### API Endpoints

```javascript
// Get current currency info
fetch('/api/currency/current')
    .then(response => response.json())
    .then(data => console.log(data.currency)); // "MYR"

// Change currency
fetch('/change-currency', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken
    },
    body: JSON.stringify({ currency: 'EUR' })
});

// Convert specific price
fetch('/api/currency/convert', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ 
        price: 100, 
        to_currency: 'MYR' 
    })
});
```

## 🗺️ Supported Countries & Currencies

| Region | Countries | Currencies |
|--------|-----------|------------|
| **Asia Pacific** | MY, SG, TH, ID, PH, VN, JP, CN, KR, IN, AU, NZ, HK, TW | MYR, SGD, THB, IDR, PHP, VND, JPY, CNY, KRW, INR, AUD, NZD, HKD, TWD |
| **Europe** | DE, FR, IT, ES, GB, CH, NO, SE, DK, PL, CZ, HU | EUR, GBP, CHF, NOK, SEK, DKK, PLN, CZK, HUF |
| **Americas** | US, CA, MX, BR, AR, CL, CO, PE | USD, CAD, MXN, BRL, ARS, CLP, COP, PEN |
| **Middle East & Africa** | AE, SA, IL, TR, ZA, EG | AED, SAR, ILS, TRY, ZAR, EGP |

**Total**: 50+ countries mapped to 33+ currencies

## ⚙️ Configuration

### Environment Variables

Add to your `.env` file:

```env
# Default currency when detection fails
DEFAULT_CURRENCY=MYR
```

### Customize Currency Rates

Update exchange rates in `config/currency.php`:

```php
'currencies' => [
    'MYR' => ['symbol' => 'RM', 'rate' => 4.68],  // Update with live rates
    'EUR' => ['symbol' => '€', 'rate' => 0.92],
    // ... more currencies
],
```

> **Production Tip**: Integrate with live exchange rate APIs like [exchangerate-api.com](https://exchangerate-api.com) or [fixer.io](https://fixer.io)

### Cache Settings

Adjust caching in `config/currency.php`:

```php
'cache' => [
    'enabled' => true,
    'ttl' => 3600,  // 1 hour cache
],
```

## 🔧 Advanced Usage

### Custom Country Detection

```php
// In a controller
$currencyService = app(\App\Services\CurrencyService::class);

// Force detect for specific IP
$currency = $currencyService->detectCurrencyByIp('203.223.45.67');

// Get currency for country code
$currency = $currencyService->getCurrencyByCountry('MY'); // Returns 'MYR'
```

### Integration with Existing Models

Update your Product model:

```php
class Product extends Model
{
    // Store prices in USD in database
    protected $fillable = ['name', 'price_usd'];
    
    // Accessor for converted price
    public function getLocalPriceAttribute()
    {
        return convert_price($this->price_usd);
    }
    
    public function getFormattedPriceAttribute()
    {
        return convert_and_format_price($this->price_usd);
    }
}
```

### Cart Integration

```php
class Cart extends Model 
{
    public function getTotalAttribute()
    {
        $usdTotal = $this->items->sum(function ($item) {
            return $item->quantity * $item->product->price_usd;
        });
        
        return convert_price($usdTotal);
    }
    
    public function getFormattedTotalAttribute()
    {
        return format_price($this->total);
    }
}
```

## 🌐 API Specification

### POST /change-currency

Change user's currency manually.

```json
{
    "currency": "MYR"
}
```

**Response:**
```json
{
    "success": true,
    "currency": "MYR",
    "symbol": "RM",
    "message": "Currency changed to MYR"
}
```

### GET /api/currency/current

Get current user's currency information.

**Response:**
```json
{
    "currency": "MYR",
    "symbol": "RM",
    "name": "Malaysian Ringgit",
    "rate": 4.68
}
```

### GET /api/currency/available

Get all supported currencies.

**Response:**
```json
{
    "currencies": {
        "USD": {"symbol": "$", "name": "US Dollar", "rate": 1.0},
        "MYR": {"symbol": "RM", "name": "Malaysian Ringgit", "rate": 4.68}
    }
}
```

## 🧪 Testing

Test the implementation by visiting your Laravel app from different locations or using VPN services. The middleware will:

1. Detect your IP address
2. Query ip-api.com for country information  
3. Map country to currency (MY → MYR, US → USD, etc.)
4. Store currency in session
5. Convert all prices automatically

### Debug Information

Check Laravel logs for currency detection:

```bash
tail -f storage/logs/laravel.log | grep "Currency"
```

You'll see logs like:
```
Currency detected for IP 203.223.45.67: MYR (MY)
Currency changed manually: USD -> MYR
```

## 🔒 Security & Performance

- **Rate Limiting**: ip-api.com allows 45 requests/minute (free tier)
- **Caching**: Results cached for 1 hour to avoid API limits
- **Error Handling**: Falls back to USD if detection fails
- **Local IP Handling**: Skips detection for local/private IPs
- **Session Security**: Currency stored securely in Laravel sessions

## 🚀 Production Deployment

1. **Update Exchange Rates**: Integrate with live exchange rate API
2. **Configure Caching**: Use Redis for better cache performance
3. **Monitor API Usage**: Track ip-api.com usage to avoid limits
4. **Add Rate Limiting**: Protect currency change endpoint
5. **Update Regularly**: Keep country mappings up to date

## 🤝 How It Works

1. **First Visit**: Middleware detects user's IP → Queries ip-api.com → Maps country to currency → Stores in session
2. **Subsequent Visits**: Uses cached currency from session
3. **Price Display**: Blade directives/helpers convert USD prices to user's currency  
4. **Manual Changes**: Users can override via currency selector
5. **API Integration**: Frontend can interact via JSON endpoints

## 📝 Example Implementation

See `example_usage.blade.php` for a complete working example showing:
- Currency selector dropdown
- Converted product prices
- Shopping cart with totals
- API testing interface
- Real-time currency switching

This system provides a seamless, automatic currency experience that increases conversion rates by showing prices in users' local currencies! 🎉