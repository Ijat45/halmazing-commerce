<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class DetectCurrency
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Run this logic only if currency or location is not already set.
        if (!Session::has('currency') || !Session::has('location_name')) {
            $this->detectAndSetLocationData($request);
        }

        return $next($request);
    }

    /**
     * Detects location and currency from IP and sets session values.
     *
     * @param \Illuminate\Http\Request $request
     */
    protected function detectAndSetLocationData(Request $request)
    {
        // Use a testing IP in local development if needed, otherwise get the real IP.
        $userIp = $request->ip() === '127.0.0.1' ? '' : $request->ip();

        // Use the API endpoint you suggested.
        $response = Http::get("http://ip-api.com/json/{$userIp}?fields=status,message,country,countryCode,city,lat,lon,currency");

        if ($response->successful() && $response->json('status') === 'success') {
            $data = $response->json();

            // Set Currency if not already set
            if (!Session::has('currency')) {
                $currencyCode = $data['currency'] ?? config('currency.default');
                $availableCurrencies = array_keys(config('currency.currencies', []));
                if (in_array($currencyCode, $availableCurrencies)) {
                    Session::put('currency', $currencyCode);
                }
            }

            // Set Location data if not already set
            if (!Session::has('location_name')) {
                Session::put('latitude', $data['lat']);
                Session::put('longitude', $data['lon']);
                Session::put('country_code', $data['countryCode']);
                Session::put('location_name', trim("{$data['city']}, {$data['country']}"));
            }
        }
    }
}