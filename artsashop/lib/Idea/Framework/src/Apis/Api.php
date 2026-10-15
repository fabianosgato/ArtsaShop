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
namespace Idea\Framework\Apis;

use Illuminate\Support\Facades\Log;

class Api
{

    protected string $key;
    protected string $password;

    /**
     * Cria o array para o envio dos dados para os Headers das requisicoes.
     * @return string[]
     */
    public static function getHeaders(): array
    {
        return [
            "User-Agent: ArtsaShop Ecommerce",
            "Cache-Control: no-cache",
            'Content-Type: application/json',
            'Content-Type: multipart/form-data'
        ];
    }

    /**
     * Metodo que realiza as chamadas na API da Fedex
     * @param string $url
     * @param array $payload Dados enviados
     * @param string $method
     * @return array|mixed
     */
    public static function sendRequest(string $url, array $payload, string $method = "POST"): mixed
    {
        // Inicializa o cURL
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 1200,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => self::getHeaders(),
        ));

        $response = curl_exec($curl);

        // Verifica se ocorreu algum erro
        if (curl_errno($curl)) {
            Log::error('Erro no cURL: ' . curl_error($curl));
            // Fecha a conexão do cURL
            curl_close($curl);
            return [];
        }

        // Retorna a resposta da API
        return json_decode($response, true);

    }

}
