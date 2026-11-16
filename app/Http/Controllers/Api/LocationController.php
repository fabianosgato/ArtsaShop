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

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function save(Request $request): JsonResponse
    {

        $validated = $request->validate([
            'country_code' => 'required|string|size:2',
            'country_name' => 'required|string',
            'state_code' => 'nullable|string',
            'state_name' => 'nullable|string',
            'city' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'currency' => 'required|string|size:3',
            'locale' => 'required|string',
            'timezone' => 'required|string',
        ]);

        // Salvar na sessão
        session()->put('user_location', $validated);

        // Compartilha com Inertia o valor
        inertia()->share(
            'userLocation',
            $validated
        );

        return response()->json(['success' => true, 'location' => $validated]);
    }
}
