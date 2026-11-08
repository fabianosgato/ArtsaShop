<?php

namespace App\Http\Middleware;

use Closure;
use GeoIp2\Database\Reader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    protected Reader $reader;

    public function __construct()
    {
        $this->reader = new Reader(
            storage_path('app/geoip/GeoLite2-Country.mmdb')
        );
    }

    public function handle(Request $request, Closure $next): Response
    {
        // 1. IP whitelist
        $whitelistIps = ['127.0.0.1', '::1'];

        if (in_array($request->ip(), $whitelistIps)) {
            return $next($request);
        }

        // 2. Bot confiável (UA + validação real)
        if ($this->isTrustedBot($request) && $this->isRealBot($request)) {
            return $next($request);
        }

        // 3. Localidades nao suportadas
        $unSupportedLocales = [
            'SG',
            'VN'
        ];

        $country = $this->detectCountry($request);
        $locale = $this->mapCountryToLocale($country);

        // 4. Bloqueio
        if (in_array($locale, $unSupportedLocales)) {

            if ($this->isBlockBot($request)) {
                Log::channel('geoip')->warning('Bot Bloqueado pelo UserAgent: '.$request->userAgent());
                abort(403, 'Access denied');
            }

            Log::channel('geoip')->warning('Acesso indesejado: ', [
                'ip' => $request->ip(),
                'country' => $country,
                'locale' => $locale,
                'url' => $request->fullUrl(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        return $next($request);
    }

    /**
     * Detecta bots por User-Agent
     */
    protected function isBlockBot(Request $request): bool
    {
        $ua = strtolower($request->userAgent() ?? '');

        $blockBots = [
            'uptimerobot',
            'bytedance',
        ];

        foreach ($blockBots as $bot) {

            if (str_contains($ua, $bot)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Detecta bots por User-Agent
     */
    protected function isTrustedBot(Request $request): bool
    {
        $ua = strtolower($request->userAgent() ?? '');

        $trustedBots = [
            'googlebot',
            'bingbot',
            'slurp', // Yahoo
        ];

        foreach ($trustedBots as $bot) {
            if (str_contains($ua, $bot)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Validação REAL (DNS reverse + forward)
     */
    protected function isRealBot(Request $request): bool
    {
        $ip = $request->ip();

        try {
            // Reverse DNS
            $host = gethostbyaddr($ip);

            if (!$host || $host === $ip) {
                return false;
            }

            // Googlebot
            if (
                str_ends_with($host, '.googlebot.com') ||
                str_ends_with($host, '.google.com')
            ) {
                return $this->validateForwardDns($host, $ip);
            }

            // Bingbot
            if (str_ends_with($host, '.search.msn.com')) {
                return $this->validateForwardDns($host, $ip);
            }

            // Yahoo (slurp)
            if (str_contains($host, 'crawl.yahoo.net')) {
                return $this->validateForwardDns($host, $ip);
            }

            return false;

        } catch (\Throwable $e) {

            Log::channel('geoip')->error('Bot validation error', [
                'ip' => $ip,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Confirma que o host resolve para o mesmo IP
     */
    protected function validateForwardDns(string $host, string $ip): bool
    {
        $ips = gethostbynamel($host);

        if (!$ips) {
            return false;
        }

        return in_array($ip, $ips);
    }

    /**
     * Detecta país
     */
    protected function detectCountry(Request $request): ?string
    {

        // Cloudflare primeiro
        if ($cfCountry = $request->header('CF-IPCountry')) {
            return $cfCountry;
        }

        try {
            $record = $this->reader->country($request->ip());

            return $record->country->isoCode;

        } catch (\Throwable $e) {

            Log::channel('geoip')->error('GeoIP detection error', [
                'ip' => $request->ip(),
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * Mapeia país → locale
     */
    protected function mapCountryToLocale(?string $countryCode): string
    {
        return match ($countryCode) {
            'CO' => 'co',
            'CN' => 'cn',
            'MX' => 'mx',
            'PT', 'BR', 'ES' => 'pt_BR',
            'US', 'GB' => 'en',
            'FR', 'BE', 'SN' => 'fr',
            'EG', 'SA' => 'ar',

            default => $countryCode,
        };
    }
}
