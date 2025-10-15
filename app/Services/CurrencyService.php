<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CurrencyService
{
    protected $config;

    public function __construct()
    {
        $this->config = config('currency');
    }

    /**
     * Detect location and currency based on user's IP address
     *
     * @param string|null $ip
     * @return array ['currency' => string, 'country' => string, 'city' => string, 'countryCode' => string]
     */
    public function detectLocationAndCurrency(?string $ip = null): array
    {
        $ip = $ip ?? $this->getClientIp();

        if ($this->isLocalIp($ip)) {
            return $this->getDefaultLocationData();
        }

        $cacheKey = $this->config['cache']['key_prefix'] . 'location_' . md5($ip);
        if ($this->config['cache']['enabled'] && Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $locationData = $this->tryIpapiCo($ip);

        if (!$locationData) {
            foreach ($this->config['geolocation']['fallback_apis'] as $fallbackUrl) {
                if (str_contains($fallbackUrl, 'ip-api.com')) {
                    $locationData = $this->tryIpApi($ip);
                } elseif (str_contains($fallbackUrl, 'ipinfo.io')) {
                    $locationData = $this->tryIpInfo($ip);
                }

                if ($locationData) {
                    break;
                }
            }
        }

        if (!$locationData) {
            $locationData = $this->getDefaultLocationData();
            Log::warning("All location detection APIs failed for IP {$ip}, using default");
        } else {
            if ($this->config['cache']['enabled']) {
                Cache::put($cacheKey, $locationData, $this->config['cache']['ttl']);
            }
            Log::info("Location detected for IP {$ip}", $locationData);
        }

        return $locationData;
    }

    /**
     * Detect currency based on IP (backward compatibility)
     *
     * @param string|null $ip
     * @return string
     */
    public function detectCurrencyByIp(?string $ip = null): string
    {
        return $this->detectLocationAndCurrency($ip)['currency'];
    }

    /**
     * Get currency by country code
     *
     * @param string $countryCode
     * @return string
     */
    public function getCurrencyByCountry(string $countryCode): string
    {
        return $this->config['country_currency_map'][$countryCode] ?? $this->getDefaultCurrency();
    }

    /**
     * Get default currency (MYR)
     *
     * @return string
     */
    public function getDefaultCurrency(): string
    {
        return $this->config['default'];
    }

    /**
     * Get current user's currency from session
     *
     * @return string
     */
    public function getCurrentCurrency(): string
    {
        return session('currency', $this->getDefaultCurrency());
    }

    /**
     * Set currency in session
     *
     * @param string $currency
     */
    public function setCurrency(string $currency): void
    {
        if ($this->isValidCurrency($currency)) {
            session(['currency' => $currency]);
        }
    }

    /**
     * Check if currency is supported
     *
     * @param string $currency
     * @return bool
     */
    public function isValidCurrency(string $currency): bool
    {
        return isset($this->config['currencies'][$currency]);
    }

    /**
     * Get currency info
     *
     * @param string|null $currency
     * @return array
     */
    public function getCurrencyInfo(?string $currency = null): array
    {
        $currency = $currency ?? $this->getCurrentCurrency();
        return $this->config['currencies'][$currency] ?? $this->config['currencies'][$this->getDefaultCurrency()];
    }

    /**
     * Get currency symbol
     *
     * @param string|null $currency
     * @return string
     */
    public function getCurrencySymbol(?string $currency = null): string
    {
        return $this->getCurrencyInfo($currency)['symbol'];
    }

    /**
     * Convert price from any currency to any currency (MYR is base)
     *
     * @param float $price
     * @param string|null $toCurrency
     * @param string|null $fromCurrency
     * @return float
     */
    public function convertPrice(float $price, ?string $toCurrency = null, ?string $fromCurrency = null): float
    {
        $fromCurrency = $fromCurrency ?? $this->getDefaultCurrency(); // base = MYR
        $toCurrency   = $toCurrency ?? $this->getCurrentCurrency();

        if ($fromCurrency === $toCurrency) {
            return round($price, $this->getCurrencyInfo($toCurrency)['decimals']);
        }

        $fromRate = $this->getCurrencyInfo($fromCurrency)['rate'];
        $toRate   = $this->getCurrencyInfo($toCurrency)['rate'];

        // Convert price to MYR, then to target
        $priceInBase = $price / $fromRate;
        $converted   = $priceInBase * $toRate;

        return round($converted, $this->getCurrencyInfo($toCurrency)['decimals']);
    }

    /**
     * Format price with symbol
     *
     * @param float $price
     * @param string|null $currency
     * @return string
     */
    public function formatPrice(float $price, ?string $currency = null): string
    {
        $currency = $currency ?? $this->getCurrentCurrency();
        $info = $this->getCurrencyInfo($currency);
        $formatted = number_format($price, $info['decimals']);

        return match ($currency) {
            'EUR' => $formatted . ' ' . $info['symbol'],
            default => $info['symbol'] . $formatted,
        };
    }

    /**
     * Convert and format in one step
     *
     * @param float $price
     * @param string|null $toCurrency
     * @param string|null $fromCurrency
     * @return string
     */
    public function convertAndFormat(float $price, ?string $toCurrency = null, ?string $fromCurrency = null): string
    {
        $converted = $this->convertPrice($price, $toCurrency, $fromCurrency);
        return $this->formatPrice($converted, $toCurrency);
    }

    /**
     * Get all available currencies
     *
     * @return array
     */
    public function getAvailableCurrencies(): array
    {
        return $this->config['currencies'];
    }

    /**
     * Get country-currency map
     *
     * @return array
     */
    public function getCountryCurrencyMap(): array
    {
        return $this->config['country_currency_map'];
    }

    /**
     * Get default location
     *
     * @return array
     */
    protected function getDefaultLocationData(): array
    {
        return [
            'currency' => $this->getDefaultCurrency(),
            'country' => 'Malaysia',
            'city' => 'Kuala Lumpur',
            'countryCode' => 'MY',
            'region' => '',
            'api_used' => 'default'
        ];
    }

    /**
     * Get client's IP
     *
     * @return string
     */
    protected function getClientIp(): string
    {
        $headers = [
            'HTTP_CF_CONNECTING_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR'
        ];

        foreach ($headers as $header) {
            if (!empty($_SERVER[$header])) {
                $ip = $_SERVER[$header];
                if (str_contains($ip, ',')) {
                    $ip = trim(explode(',', $ip)[0]);
                }
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                    return $ip;
                }
            }
        }

        return request()->ip() ?? '127.0.0.1';
    }

    protected function isLocalIp(string $ip): bool
    {
        return !filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
    }

    // --- Location detection helpers ---

    protected function tryIpapiCo(string $ip): ?array
    {
        try {
            $response = Http::timeout($this->config['geolocation']['timeout'])
                ->get($this->config['geolocation']['api_url'] . $ip . '/json/');

            if ($response->successful()) {
                $data = $response->json();
                if (!isset($data['error']) && isset($data['country_code'])) {
                    $countryCode = $data['country_code'];
                    return [
                        'currency' => $this->getCurrencyByCountry($countryCode),
                        'country' => $data['country_name'] ?? 'Unknown',
                        'city' => $data['city'] ?? 'Unknown',
                        'countryCode' => $countryCode,
                        'region' => $data['region'] ?? '',
                        'api_used' => 'ipapi.co'
                    ];
                }
            }
        } catch (\Exception $e) {
            Log::warning("ipapi.co API failed for IP {$ip}: " . $e->getMessage());
        }
        return null;
    }

    protected function tryIpApi(string $ip): ?array
    {
        try {
            $response = Http::timeout($this->config['geolocation']['timeout'])
                ->get("http://ip-api.com/json/{$ip}?fields=status,country,countryCode,city,regionName");

            if ($response->successful()) {
                $data = $response->json();
                if ($data['status'] === 'success' && isset($data['countryCode'])) {
                    return [
                        'currency' => $this->getCurrencyByCountry($data['countryCode']),
                        'country' => $data['country'] ?? 'Unknown',
                        'city' => $data['city'] ?? 'Unknown',
                        'countryCode' => $data['countryCode'],
                        'region' => $data['regionName'] ?? '',
                        'api_used' => 'ip-api.com'
                    ];
                }
            }
        } catch (\Exception $e) {
            Log::warning("ip-api.com API failed for IP {$ip}: " . $e->getMessage());
        }
        return null;
    }

    protected function tryIpInfo(string $ip): ?array
    {
        try {
            $response = Http::timeout($this->config['geolocation']['timeout'])
                ->get("https://ipinfo.io/{$ip}/json");

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['country'])) {
                    $countryCode = $data['country'];
                    return [
                        'currency' => $this->getCurrencyByCountry($countryCode),
                        'country' => $this->getCountryNameByCode($countryCode),
                        'city' => $data['city'] ?? 'Unknown',
                        'countryCode' => $countryCode,
                        'region' => $data['region'] ?? '',
                        'api_used' => 'ipinfo.io'
                    ];
                }
            }
        } catch (\Exception $e) {
            Log::warning("ipinfo.io API failed for IP {$ip}: " . $e->getMessage());
        }
        return null;
    }

    protected function getCountryNameByCode(string $code): string
    {
        $map = [
            'US'=>'United States','CA'=>'Canada','MX'=>'Mexico',
            'GB'=>'United Kingdom','DE'=>'Germany','FR'=>'France',
            'IT'=>'Italy','ES'=>'Spain','NL'=>'Netherlands',
            'MY'=>'Malaysia','SG'=>'Singapore','TH'=>'Thailand',
            'ID'=>'Indonesia','PH'=>'Philippines','VN'=>'Vietnam',
            'JP'=>'Japan','CN'=>'China','KR'=>'South Korea',
            'IN'=>'India','AU'=>'Australia','NZ'=>'New Zealand',
            'BR'=>'Brazil','AR'=>'Argentina','CL'=>'Chile',
        ];
        return $map[$code] ?? $code;
    }

    /**
     * Get/set user location in session
     */
    public function getCurrentLocation(): array
    {
        return session('location', $this->getDefaultLocationData());
    }

    public function setLocation(array $location): void
    {
        session(['location' => $location]);
    }
}
