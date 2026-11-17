<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use InteractionDesignFoundation\GeoIP\Facades\GeoIP;
use Throwable;

class DetectUserLocation
{

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {

        // Skip if already has location in session
        if (session()->has('user_location')) {
            return $next($request);
        }

        // Skip for non-GET requests (APIs, POSTs, etc.)
        if (!$request->isMethod('get')) {
            return $next($request);
        }

        // Skip for asset/API routes
        if ($request->is('api/*') || $request->is('_inertia/*') || $request->is('_boost/*') || $request->is('wsdadm/*')) {
            return $next($request);
        }

        try {

            // Retorna o IP do cliente
            $ip = $request->getClientIp();

            // Busca a localização.
            $location = GeoIP::getLocation($ip);

            if ($location) {
                $data = $this->buildLocationData($location, $ip);
                $request->session()->put('user_location', $data);
                Inertia::share([
                    'userLocation' => $data
                ]);
            }
        } catch (Throwable $e) {
            Log::warning('GeoIP lookup failed', [
                'ip' => $request->getClientIp(),
                'error' => $e->getMessage(),
            ]);
        }

        return $next($request);
    }

    /**
     * Build location data array from GeoIP location object
     */
    private function buildLocationData($location, string $ip): array
    {
        return [
            'ip' => $location->ip ?? $ip,
            'country_code' => $location->countryCode ?? $location->isoCode,
            'country_name' => $location->country ?? $location->countryName,
            'state_code' => $location->regionCode ?? $location->subdivisionCode,
            'state_name' => $location->regionName ?? $location->subdivisionName,
            'city' => $location->city,
            'postal_code' => $location->postalCode ?? $location->zipCode,
            'latitude' => $location->latitude,
            'longitude' => $location->longitude,
            'timezone' => $location->timezone,
            'currency' => $location->currency ?? $this->getCurrencyByCountry($location->countryCode ?? 'BR'),
            'locale' => $this->getLocaleByCountry($location->countryCode ?? 'BR'),
        ];
    }

    /**
     * Check if IP is local/private (development)
     */
    private function isLocalIp(?string $ip): bool
    {
        if (!$ip) return true;

        $privateRanges = [
            '127.0.0.0/8',      // Loopback
            '10.0.0.0/8',       // Private Class A
            '172.16.0.0/12',    // Private Class B
            '192.168.0.0/16',   // Private Class C
            '169.254.0.0/16',   // Link-local
            '::1/128',          // IPv6 Loopback
            'fe80::/10',        // IPv6 Link-local
        ];

        foreach ($privateRanges as $range) {
            if ($this->ipInRange($ip, $range)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if IP is in CIDR range
     */
    private function ipInRange(string $ip, string $range): bool
    {
        if (!str_contains($range, '/')) {
            return $ip === $range;
        }

        [$rangeIp, $cidr] = explode('/', $range);

        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            // Simplified IPv6 check - for local dev just check common prefixes
            return str_starts_with($ip, '::1') || str_starts_with($ip, 'fe80:');
        }

        $ipLong = ip2long($ip);
        $rangeLong = ip2long($rangeIp);

        if ($ipLong === false || $rangeLong === false) {
            return false;
        }

        $mask = -1 << (32 - (int)$cidr);
        return ($ipLong & $mask) === ($rangeLong & $mask);
    }

    /**
     * Get currency by country code
     */
    private function getCurrencyByCountry(?string $code): string
    {
        return match (strtoupper($code ?? '')) {
            'BR' => 'BRL',
            'CA' => 'CAD',
            'MX' => 'MXN',
            'AR' => 'ARS',
            'CL' => 'CLP',
            'CO' => 'COP',
            'PE' => 'PEN',
            'UY' => 'UYU',
            'PT', 'DE', 'FR', 'ES', 'IT', 'NL', 'BE', 'AT', 'IE', 'FI', 'GR' => 'EUR',
            'GB' => 'GBP',
            'JP' => 'JPY',
            'CN' => 'CNY',
            'IN' => 'INR',
            'AU' => 'AUD',
            'NZ' => 'NZD',
            'ZA' => 'ZAR',
            default => 'USD',
        };
    }

    /**
     * Get locale by country code
     */
    private function getLocaleByCountry(?string $code): string
    {
        return match (strtoupper($code ?? '')) {
            'BR' => 'pt_BR',
            'PT' => 'pt_PT',
            'CA', 'MX', 'AR', 'CL', 'CO', 'PE', 'UY', 'ES' => 'es_ES',
            'DE' => 'de_DE',
            'FR' => 'fr_FR',
            'IT' => 'it_IT',
            'NL' => 'nl_NL',
            'JP' => 'ja_JP',
            'CN' => 'zh_CN',
            default => 'en_US',
        };
    }
}
