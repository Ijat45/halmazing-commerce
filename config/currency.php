<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Currency
    |--------------------------------------------------------------------------
    |
    | The default currency to use when location detection fails or the
    | detected country is not mapped to any currency.
    |
    */
    'default' => env('DEFAULT_CURRENCY', 'MYR'),

    /*
    |--------------------------------------------------------------------------
    | IP Geolocation API Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for the IP geolocation service. We use ipapi.co
    | which provides reliable location detection with good accuracy.
    |
    */
    'geolocation' => [
        'api_url' => 'https://ipapi.co/',
        'timeout' => 5,
        'fallback_apis' => [
            'http://ip-api.com/json/',
            'https://ipinfo.io/json',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Country to Currency Mapping
    |--------------------------------------------------------------------------
    */
    'country_currency_map' => [
        // North America
        'US' => 'USD', 'CA' => 'CAD', 'MX' => 'MXN',
        
        // Europe
        'DE' => 'EUR', 'FR' => 'EUR', 'IT' => 'EUR', 'ES' => 'EUR',
        'NL' => 'EUR', 'BE' => 'EUR', 'AT' => 'EUR', 'PT' => 'EUR',
        'FI' => 'EUR', 'IE' => 'EUR', 'GR' => 'EUR', 'LU' => 'EUR',
        'GB' => 'GBP', 'CH' => 'CHF', 'NO' => 'NOK', 'SE' => 'SEK',
        'DK' => 'DKK', 'PL' => 'PLN', 'CZ' => 'CZK', 'HU' => 'HUF',
        'RO' => 'RON', 'BG' => 'BGN', 'HR' => 'EUR',
        
        // Asia Pacific
        'JP' => 'JPY', 'CN' => 'CNY', 'KR' => 'KRW', 'IN' => 'INR',
        'AU' => 'AUD', 'NZ' => 'NZD', 'SG' => 'SGD', 'HK' => 'HKD',
        'TW' => 'TWD', 'TH' => 'THB', 'MY' => 'MYR', 'ID' => 'IDR',
        'PH' => 'PHP', 'VN' => 'VND',
        
        // Middle East & Africa
        'AE' => 'AED', 'SA' => 'SAR', 'IL' => 'ILS', 'TR' => 'TRY',
        'ZA' => 'ZAR', 'EG' => 'EGP', 'NG' => 'NGN', 'KE' => 'KES',
        
        // South America
        'BR' => 'BRL', 'AR' => 'ARS', 'CL' => 'CLP', 'CO' => 'COP',
        'PE' => 'PEN', 'UY' => 'UYU', 'PY' => 'PYG', 'BO' => 'BOB',
        'EC' => 'USD', 'VE' => 'VES',
    ],

    /*
    |--------------------------------------------------------------------------
    | Currency Information
    |--------------------------------------------------------------------------
    |
    | MYR is now the base currency (1.0). All other rates are relative to MYR.
    |
    */
    'currencies' => [
        'MYR' => ['symbol' => 'RM', 'name' => 'Malaysian Ringgit', 'decimals' => 2, 'rate' => 1.0],
        'USD' => ['symbol' => '$', 'name' => 'US Dollar', 'decimals' => 2, 'rate' => 0.21],
        'EUR' => ['symbol' => '€', 'name' => 'Euro', 'decimals' => 2, 'rate' => 0.20],
        'GBP' => ['symbol' => '£', 'name' => 'British Pound', 'decimals' => 2, 'rate' => 0.17],
        'JPY' => ['symbol' => '¥', 'name' => 'Japanese Yen', 'decimals' => 0, 'rate' => 31.9],
        'CAD' => ['symbol' => 'C$', 'name' => 'Canadian Dollar', 'decimals' => 2, 'rate' => 0.29],
        'AUD' => ['symbol' => 'A$', 'name' => 'Australian Dollar', 'decimals' => 2, 'rate' => 0.32],
        'CHF' => ['symbol' => 'CHF', 'name' => 'Swiss Franc', 'decimals' => 2, 'rate' => 0.19],
        'CNY' => ['symbol' => '¥', 'name' => 'Chinese Yuan', 'decimals' => 2, 'rate' => 1.54],
        'INR' => ['symbol' => '₹', 'name' => 'Indian Rupee', 'decimals' => 2, 'rate' => 17.8],
        'KRW' => ['symbol' => '₩', 'name' => 'South Korean Won', 'decimals' => 0, 'rate' => 286.0],
        'SGD' => ['symbol' => 'S$', 'name' => 'Singapore Dollar', 'decimals' => 2, 'rate' => 0.29],
        'HKD' => ['symbol' => 'HK$', 'name' => 'Hong Kong Dollar', 'decimals' => 2, 'rate' => 1.67],
        'NZD' => ['symbol' => 'NZ$', 'name' => 'New Zealand Dollar', 'decimals' => 2, 'rate' => 0.36],
        'SEK' => ['symbol' => 'kr', 'name' => 'Swedish Krona', 'decimals' => 2, 'rate' => 2.33],
        'NOK' => ['symbol' => 'kr', 'name' => 'Norwegian Krone', 'decimals' => 2, 'rate' => 2.30],
        'DKK' => ['symbol' => 'kr', 'name' => 'Danish Krone', 'decimals' => 2, 'rate' => 1.46],
        'PLN' => ['symbol' => 'zł', 'name' => 'Polish Złoty', 'decimals' => 2, 'rate' => 0.88],
        'BRL' => ['symbol' => 'R$', 'name' => 'Brazilian Real', 'decimals' => 2, 'rate' => 1.07],
        'MXN' => ['symbol' => '$', 'name' => 'Mexican Peso', 'decimals' => 2, 'rate' => 3.81],
        'ZAR' => ['symbol' => 'R', 'name' => 'South African Rand', 'decimals' => 2, 'rate' => 4.00],
        'TRY' => ['symbol' => '₺', 'name' => 'Turkish Lira', 'decimals' => 2, 'rate' => 5.80],
        'AED' => ['symbol' => 'د.إ', 'name' => 'UAE Dirham', 'decimals' => 2, 'rate' => 0.78],
        'SAR' => ['symbol' => '﷼', 'name' => 'Saudi Riyal', 'decimals' => 2, 'rate' => 0.80],
        'IDR' => ['symbol' => 'Rp', 'name' => 'Indonesian Rupiah', 'decimals' => 0, 'rate' => 3300.0],
        'PHP' => ['symbol' => '₱', 'name' => 'Philippine Peso', 'decimals' => 2, 'rate' => 12.05],
        'VND' => ['symbol' => '₫', 'name' => 'Vietnamese Dong', 'decimals' => 0, 'rate' => 5200.0],
        'ILS' => ['symbol' => '₪', 'name' => 'Israeli Shekel', 'decimals' => 2, 'rate' => 0.79],
        'CZK' => ['symbol' => 'Kč', 'name' => 'Czech Koruna', 'decimals' => 2, 'rate' => 4.95],
        'HUF' => ['symbol' => 'Ft', 'name' => 'Hungarian Forint', 'decimals' => 0, 'rate' => 78.2],
        'TWD' => ['symbol' => 'NT$', 'name' => 'Taiwan Dollar', 'decimals' => 0, 'rate' => 6.86],
        'EGP' => ['symbol' => '£', 'name' => 'Egyptian Pound', 'decimals' => 2, 'rate' => 6.60],
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Settings
    |--------------------------------------------------------------------------
    */
    'cache' => [
        'enabled' => true,
        'ttl' => 3600,
        'key_prefix' => 'currency_geo_',
    ],
];
