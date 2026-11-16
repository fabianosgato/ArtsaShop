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

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
        $request->session()->put('user_location', $validated);

        // Compartilha com Inertia o valor
        inertia()->share(
            'userLocation',
            $validated
        );

        return response()->json(['success' => true, 'location' => $validated]);

    }

    public function lookup(string $cep): JsonResponse
    {
        $cleanCep = preg_replace('/\D/', '', $cep);

        if (strlen($cleanCep) !== 8) {
            return response()->json(['error' => 'CEP inválido'], 400);
        }

        // Tenta ViaCEP primeiro
        $response = Http::timeout(3)->get("https://viacep.com.br/ws/{$cleanCep}/json/");

        if ($response->successful() && !$response->json('erro')) {
            $data = $response->json();
            return response()->json([
                'cep' => $data['cep'],
                'logradouro' => $data['logradouro'],
                'bairro' => $data['bairro'],
                'cidade' => $data['localidade'],
                'estado' => $data['uf'],
                'estado_nome' => $this->getEstadoNome($data['uf']),
            ]);
        }

        // Fallback BrasilAPI
        $response = Http::timeout(3)->get("https://brasilapi.com.br/api/cep/v1/{$cleanCep}");

        if ($response->successful()) {
            $data = $response->json();
            return response()->json([
                'cep' => $data['cep'],
                'logradouro' => $data['street'],
                'bairro' => $data['neighborhood'],
                'cidade' => $data['city'],
                'estado' => $data['state'],
                'estado_nome' => $data['state'],
            ]);
        }

        return response()->json(['error' => 'CEP não encontrado'], 404);
    }

    private function getEstadoNome(string $uf): string
    {
        $estados = [
            'AC' => 'Acre', 'AL' => 'Alagoas', 'AP' => 'Amapá', 'AM' => 'Amazonas',
            'BA' => 'Bahia', 'CE' => 'Ceará', 'DF' => 'Distrito Federal', 'ES' => 'Espírito Santo',
            'GO' => 'Goiás', 'MA' => 'Maranhão', 'MT' => 'Mato Grosso', 'MS' => 'Mato Grosso do Sul',
            'MG' => 'Minas Gerais', 'PA' => 'Pará', 'PB' => 'Paraíba', 'PR' => 'Paraná',
            'PE' => 'Pernambuco', 'PI' => 'Piauí', 'RJ' => 'Rio de Janeiro', 'RN' => 'Rio Grande do Norte',
            'RS' => 'Rio Grande do Sul', 'RO' => 'Rondônia', 'RR' => 'Roraima', 'SC' => 'Santa Catarina',
            'SP' => 'São Paulo', 'SE' => 'Sergipe', 'TO' => 'Tocantins',
        ];
        return $estados[$uf] ?? $uf;
    }

}
