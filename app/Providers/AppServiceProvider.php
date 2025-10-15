<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Services\CurrencyService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set default pagination view to Bootstrap 5
        Paginator::useBootstrapFive();
        
        // Register currency Blade directives
        $this->registerCurrencyBladeDirectives();
    }
    
    /**
     * Register currency-related Blade directives
     */
    protected function registerCurrencyBladeDirectives(): void
    {
        // @currency($usdPrice) - Convert and format price
        Blade::directive('currency', function ($expression) {
            return "<?php echo convert_and_format_price({$expression}); ?>";
        });
        
        // @price($price) - Format price with current currency symbol
        Blade::directive('price', function ($expression) {
            return "<?php echo format_price({$expression}); ?>";
        });
        
        // @currencySymbol() - Display current currency symbol
        Blade::directive('currencySymbol', function ($expression = '') {
            return "<?php echo currency_symbol({$expression}); ?>";
        });
        
        // @currentCurrency() - Display current currency code
        Blade::directive('currentCurrency', function () {
            return "<?php echo current_currency(); ?>";
        });
        
        // @currencySelect - Display currency selector dropdown
        Blade::directive('currencySelect', function ($expression = '') {
            $params = $expression ? "({$expression})" : '()';
            return "<?php echo view('components.currency-select')->with('attributes', {$params})->render(); ?>";
        });
    }
}
