<?php

namespace App\Http\Controllers;

use App\Services\CurrencyService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class CurrencyController extends Controller
{
    protected $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    /**
     * Change user's currency via AJAX
     */
    public function changeCurrency(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'currency' => 'required|string|in:' . implode(',', array_keys($this->currencyService->getAvailableCurrencies())),
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Invalid currency selected.', 'errors' => $validator->errors()], 422);
        }

        $currency = strtoupper($request->input('currency'));
        $oldCurrency = session()->get('currency', config('currency.default')); // capture old currency

        try {
            $this->currencyService->setCurrency($currency);

            Log::info("Currency changed manually", [
                'old_currency' => $oldCurrency,
                'new_currency' => $currency,
                'user_ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            return response()->json([
                'success' => true,
                'currency' => $currency,
                'symbol' => $this->currencyService->getCurrencySymbol($currency),
                'message' => "Currency changed to {$currency}"
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to change currency", [
                'currency' => $currency,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to change currency. Please try again.'
            ], 500);
        }
    }

    /**
     * Get current currency info
     */
    public function getCurrentCurrency(): JsonResponse
    {
        $currency = $this->currencyService->getCurrentCurrency();
        $info = $this->currencyService->getCurrencyInfo($currency);

        return response()->json([
            'currency' => $currency,
            'symbol' => $info['symbol'],
            'name' => $info['name'],
            'rate' => $info['rate']
        ]);
    }

    /**
     * Get all available currencies
     */
    public function getAvailableCurrencies(): JsonResponse
    {
        return response()->json([
            'currencies' => $this->currencyService->getAvailableCurrencies()
        ]);
    }

    /**
     * Convert price to different currency
     */
    public function convertPrice(Request $request): JsonResponse
    {
        $request->validate([
            'price' => 'required|numeric|min:0',
            'from_currency' => 'nullable|string|size:3',
            'to_currency' => 'required|string|size:3'
        ]);

        $price = $request->input('price');
        $fromCurrency = strtoupper($request->input('from_currency', config('currency.default'))); // default to MYR
        $toCurrency = strtoupper($request->input('to_currency'));

        if (!$this->currencyService->isValidCurrency($toCurrency)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid target currency.'
            ], 400);
        }

        try {
            // Convert price (base currency is now MYR)
            $convertedPrice = $this->currencyService->convertPrice($price, $toCurrency, $fromCurrency);
            $formattedPrice = $this->currencyService->formatPrice($convertedPrice, $toCurrency);

            return response()->json([
                'success' => true,
                'original_price' => $price,
                'converted_price' => $convertedPrice,
                'formatted_price' => $formattedPrice,
                'currency' => $toCurrency
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to convert price.'
            ], 500);
        }
    }
}
