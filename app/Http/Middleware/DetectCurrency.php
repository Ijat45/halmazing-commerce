<?php

namespace App\Http\Middleware;

use App\Services\CurrencyService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class DetectCurrency
{
    protected $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only perform auto-detection if no currency is set in the session at all.
        // This respects both manual changes and previous auto-detections.
        if ($this->shouldDetectCurrency($request)) {
            $locationData = $this->currencyService->detectLocationAndCurrency();
            
            // Set the currency and location based on detection.
            $this->currencyService->setCurrency($locationData['currency']);
            $this->currencyService->setLocation($locationData);
            
            Log::info("Currency auto-detected for IP: " . $request->ip(), [
                'country' => $locationData['country'],
                'currency' => $locationData['currency'],
                'api_used' => $locationData['api_used'] ?? 'unknown',
            ]);
        }

        return $next($request);
    }

    /**
     * Determine if we should detect currency for this request
     *
     * @param Request $request
     * @return bool
     */
    protected function shouldDetectCurrency(Request $request): bool
    {
        // If a currency is already in the session (either from a previous detection or a manual change),
        // we don't need to detect it again.
        if (session()->has('currency')) {
            return false;
        }

        // Skip detection for API routes, as they are stateless.
        if ($request->is('api/*') || $request->is('webhook/*')) {
            return false;
        }

        return true;
    }
}
