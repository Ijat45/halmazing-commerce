<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        // --- Reverse Geocode to get Country and City ---
        $response = Http::get("http://ip-api.com/json/?fields=status,message,country,countryCode,city,currency");
        
        if (!$response->successful() || $response->json('status') !== 'success') {
            // Fallback if reverse geocoding fails
            Session::put('location_name', 'Location Set');
            return response()->json(['success' => true, 'message' => 'Location coordinates set.']);
        }

        $data = $response->json();
        $countryCode = $data['countryCode'];
        $locationName = trim("{$data['city']}, {$data['country']}");

        $countryMap = config('currency.country_currency_map', []);
        
        // Update currency based on the geocoded country
        if (array_key_exists($countryCode, $countryMap)) {
            Session::put('currency', $countryMap[$countryCode]);
        }

        Session::put('country_code', $countryCode);
        Session::put('location_name', $locationName);

        return response()->json(['success' => true, 'message' => "Location set to {$locationName}."]);
    }
}
