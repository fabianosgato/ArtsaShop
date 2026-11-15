<?php
/**
 * Fabiano Gato
 *
 * NOTICE OF LICENSE
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 *
 * É concedida permissão, gratuitamente, a qualquer pessoa que obtenha uma cópia
 * deste software e arquivos de documentação associados
 *
 *****************************************************
 *
 * @copyright    Copyright (c) Fabiano Gato
 * @author       Fabiano Gato <fabianogattoti@gmail.com>
 *
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Torann\GeoIP\Facades\GeoIP;

class DetectUserLocation
{

    public function handle(Request $request, Closure $next)
    {

        // Skip se já tem na sessão
        if (session()->has('user_location')) {
            return $next($request);
        }

        $ip = $request->getClientIp();

        $location = GeoIP::getLocation($ip);

        dd($location);

        if ($location) {
            $data = [
                'ip' => $location->ip,
                'country_code' => $location->iso_code,
                'country_name' => $location->country,
                'state_code' => $location->state,
                'state_name' => $location->state_name,
                'city' => $location->city,
                'postal_code' => $location->postal_code,
                'latitude' => $location->lat,
                'longitude' => $location->lon,
                'timezone' => $location->timezone,
                'currency' => $this->getCurrencyByCountry($location->iso_code),
            ];

            // Salvar na sessão
            $request->session()->put('user_location', $data);

            // Compartilhar com Inertia/Vue
            \Inertia::share('userLocation', $data);
        }

        return $next($request);
    }

    private function getCurrencyByCountry(string $code): string
    {
        return match ($code) {
            'BR' => 'BRL',
            'US' => 'USD',
            'PT' => 'EUR',
            default => 'USD',
        };
    }
}
