<?php

if (!function_exists('currency')) {
    /**
     * Get the CurrencyService instance
     *
     * @return \App\Services\CurrencyService
     */
    function currency()
    {
        return app(\App\Services\CurrencyService::class);
    }
}

if (!function_exists('convert_price')) {
    /**
     * Convert price from MYR (base currency) to user's currency
     *
     * @param float $myrPrice
     * @param string|null $currency
     * @return float
     */
    function convert_price(float $myrPrice, ?string $currency = null): float
    {
        return currency()->convertPrice($myrPrice, $currency);
    }
}

if (!function_exists('format_price')) {
    /**
     * Format price with currency symbol
     *
     * @param float $price
     * @param string|null $currency
     * @return string
     */
    function format_price(float $price, ?string $currency = null): string
    {
        return currency()->formatPrice($price, $currency);
    }
}

if (!function_exists('convert_and_format_price')) {
    /**
     * Convert MYR price and format with currency symbol
     *
     * @param float $myrPrice
     * @param string|null $currency
     * @return string
     */
    function convert_and_format_price(float $myrPrice, ?string $currency = null): string
    {
        return currency()->convertAndFormat($myrPrice, $currency);
    }
}

if (!function_exists('currency_symbol')) {
    /**
     * Get currency symbol
     *
     * @param string|null $currency
     * @return string
     */
    function currency_symbol(?string $currency = null): string
    {
        return currency()->getCurrencySymbol($currency);
    }
}

if (!function_exists('current_currency')) {
    /**
     * Get current user's detected or default currency
     *
     * @return string
     */
    function current_currency(): string
    {
        return currency()->getCurrentCurrency();
    }
}

if (!function_exists('available_currencies')) {
    /**
     * Get all available currencies with symbols and names
     *
     * @return array
     */
    function available_currencies(): array
    {
        return currency()->getAvailableCurrencies();
    }
}
