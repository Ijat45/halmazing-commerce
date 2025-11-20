<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class LocationController extends Controller
{
    /**
     * Change the user's location and associated currency.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function change(Request $request)
    {
        $request->validate([
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
        ]);

        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');

        // Store precise location in session
        Session::put('latitude', $latitude);
        Session::put('longitude', $longitude);

        // Use Nominatim (OpenStreetMap) for reverse geocoding
        $nominatimUrl = 'https://nominatim.openstreetmap.org/reverse';
        $response = Http::withHeaders([
            'User-Agent' => 'HalmazingCommerce/1.0 (halmazing.com contact@halmazing.com)',
            'Referer' => config('app.url', 'https://halmazing.com'),
        ])->get($nominatimUrl, [
            'lat' => $latitude,
            'lon' => $longitude,
            'format' => 'json',
            'addressdetails' => 1,
        ]);

        if (!$response->successful() || !$response->json('address')) {
            Log::error('Reverse geocoding failed', [
                'latitude' => $latitude,
                'longitude' => $longitude,
                'response' => $response->body(),
            ]);
            Session::put('location_name', 'Unknown Location');
            return response()->json([
                'success' => false,
                'message' => 'Unable to detect your location. Please try again later.'
            ], 422);
        }

        $address = $response->json('address');
        $country = $address['country'] ?? '';
        $countryCode = $address['country_code'] ?? '';
        $city = $address['city'] ?? ($address['town'] ?? ($address['village'] ?? ''));
        $locationName = trim(($city ? $city . ', ' : '') . $country);

        $countryMap = config('currency.country_currency_map', []);

        // Update currency based on the geocoded country
        if ($countryCode && array_key_exists(strtoupper($countryCode), $countryMap)) {
            Session::put('currency', $countryMap[strtoupper($countryCode)]);
        }

        Session::put('country_code', strtoupper($countryCode));
        Session::put('location_name', $locationName);

        return response()->json(['success' => true, 'message' => "Location set to {$locationName}."]);
    }
}
