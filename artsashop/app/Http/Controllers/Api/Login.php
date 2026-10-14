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
use Idea\Framework\Concerns\ResultApiResponse;
use Idea\Framework\Services\Auth\TokenService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class Login extends Controller
{

    use ResultApiResponse;

    public function store(
        Request $request,
        TokenService $tokenService
    ): JsonResponse
    {

        if ($request->isJson()) {

            $validated = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required', 'string'],
                'device_name' => ['required', 'string', 'max:255'],
            ]);

            $token = $tokenService->issueToken(
                $validated['email'],
                $validated['password'],
                $validated['device_name'],
            );

            return response()->json([
                'token' => $token,
            ]);

        }

        return response()->json([
            $this->error(
                'Request inválido para requisição'
            )
        ]);

    }

    public function delete(
        Request $request,
        TokenService $tokenService
    ): JsonResponse
    {
        $tokenService->deleteToken();

        return response()->json([

        ]);

    }

}
