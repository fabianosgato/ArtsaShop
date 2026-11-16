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
use Illuminate\Support\Facades\Http;

class ZipCodeController extends Controller
{
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
