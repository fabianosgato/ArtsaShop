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
declare(strict_types=1);

namespace Idea\Framework\Services\Auth;

use Idea\Framework\Contracts\Auth\AccessTokenIssuerInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use LogicException;

class SanctumAccessTokenIssuer implements AccessTokenIssuerInterface
{
    public function issue(
        Authenticatable $user,
        string          $deviceName
    ): string
    {

        if (!method_exists($user, 'createToken')) {
            throw new LogicException(
                'O usuário não suporta emissão de tokens via Sanctum.'
            );
        }

        $accessToken = $user->createToken($deviceName);

        return $accessToken->plainTextToken;

    }
}
