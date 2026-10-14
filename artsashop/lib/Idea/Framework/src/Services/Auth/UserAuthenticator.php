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

use Idea\Framework\Interfaces\Auth\UserAuthenticatorInterface;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

class UserAuthenticator implements UserAuthenticatorInterface
{
    public function authenticate(
        string $email,
        string $password
    ): Authenticatable
    {

        $provider = Auth::guard()->getProvider();

        $user = $provider->retrieveByCredentials([
            'email' => $email,
        ]);

        if (
            $user === null ||
            !$provider->validateCredentials($user, [
                'password' => $password,
            ]) ||
            !($user->status ?? false)
        ) {
            throw new AuthenticationException(
                'Credenciais inválidas.'
            );
        }

        return $user;

    }

}
