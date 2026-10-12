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
 * O UserAuthenticatorInterface autentica o usuário.
 * O AccessTokenIssuerInterface define o contrato para emissão
 * de tokens de acesso.
 *
 * A implementação concreta pode utilizar Sanctum ou outro
 * mecanismo compatível, sem alterar o TokenService.
 */
declare(strict_types=1);

namespace Idea\Framework\Interfaces\Auth;

use Illuminate\Contracts\Auth\Authenticatable;

interface AccessTokenIssuerInterface
{
    /**
     * Issue an access token for an authenticated user.
     */
    public function issue(
        Authenticatable $user,
        string $deviceName
    ): string;
}
