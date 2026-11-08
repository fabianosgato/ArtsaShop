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
namespace Tests\Unit\Services\Auth;

use App\Models\User;
use Idea\Framework\Services\Auth\UserAuthenticator;
use Illuminate\Auth\SessionGuard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Facades\Auth;
use Mockery;
use Tests\TestCase;

class UserAuthenticatorTest extends TestCase
{

    public function test_authenticates_an_active_user_with_valid_credentials(): void
    {
        // Arrange: prepara o usuário e as dependências simuladas.
        $user = new User();
        $user->status = true;

        // Utiliza o Mockery para Criar um usuario para o teste
        $provider = Mockery::mock(UserProvider::class);

        $provider->shouldReceive('retrieveByCredentials')
            ->once()
            ->with(['email' => 'fabiano@example.com'])
            ->andReturn($user);

        $provider->shouldReceive('validateCredentials')
            ->once()
            ->with($user, ['password' => 'password123'])
            ->andReturn(true);

        // Utiliza o Mockery para criar a sessão
        $guard = Mockery::mock(SessionGuard::class);

        $guard->shouldReceive('getProvider')
            ->once()
            ->andReturn($provider);

        Auth::shouldReceive('guard')
            ->once()
            ->andReturn($guard);

        // Act: executa a classe que queremos testar.
        $authenticator = new UserAuthenticator();

        // Valida se o usuario criado na preparação funcionou
        $authenticatedUser = $authenticator->authenticate(
            'fabiano@example.com',
            'password123'
        );

        // Assert: verifica o resultado.
        $this->assertSame($user, $authenticatedUser);
    }

    public function test_rejects_invalid_password(): void
    {
        $user = new User();
        $user->status = true;

        $provider = Mockery::mock(UserProvider::class);

        $provider->shouldReceive('retrieveByCredentials')
            ->once()
            ->with(['email' => 'fabiano@example.com'])
            ->andReturn($user);

        $provider->shouldReceive('validateCredentials')
            ->once()
            ->with($user, ['password' => 'wrong-password'])
            ->andReturn(false);

        $guard = Mockery::mock(SessionGuard::class);

        $guard->shouldReceive('getProvider')
            ->once()
            ->andReturn($provider);

        Auth::shouldReceive('guard')
            ->once()
            ->andReturn($guard);

        $authenticator = new UserAuthenticator();

        $this->expectException(
            \Illuminate\Auth\AuthenticationException::class
        );

        $authenticator->authenticate(
            'fabiano@example.com',
            'wrong-password'
        );

    }


}
