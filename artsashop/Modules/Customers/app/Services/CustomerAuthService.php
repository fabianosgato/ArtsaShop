<?php
/**
 * Fabiano Gato
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 *
 * Não editar ou acrescentar à este arquivo se você quiser fazer o upgrade para versões
 * mais recentes no futuro.
 *****************************************************
 *
 * @copyright    Copyright (c) Fabiano Gato
 * @author       Fabiano Gato <fabianogattoti@gmail.com>
 *
 */
namespace Modules\Customers\Services;

use App\Models\CustomerEntity;
use Idea\Framework\Repository\Customer\CustomerEntityRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerAuthService
{
    /**
     * Realiza login do cliente
     */
    public function login(string $email, string $password): bool
    {
        return Auth::guard('customer')->attempt([
            'customer_email' => $email,
            'password'       => $password,
        ]);
    }

    /**
     * Cria o cliente e já autentica
     */
    public function registerAndLogin(array $data): CustomerEntity
    {

        // Cria o cliente no sistema
        $customer = CustomerEntityRepository::createCustomer([
            'customer_name'   => $data['customer_name'],
            'customer_email'  => $data['customer_email'],
            'vat_number'      => $data['vat_number'],
            'date_of_birth'   => $data['date_of_birth'] ?? null,
            'customer_passwd' => Hash::make($data['password']),
        ]);

        Auth::guard('customer')->login($customer);

        return $customer;

    }

    /**
     * Metodo usado para Atualizar/Cadastrar o Cliente na base de dados vindo do Google/Facebook
     * @param array $data
     * @return \App\Models\CustomerEntity
     */
    public function findOrCreateSocialUser(array $data)
    {

        // Verifica se o cliente existe na base
        $customer = CustomerEntityRepository::getData()
            ->where('customer_email', $data['email'])
            ->first();

        if ($customer) {
            return $customer;
        }

        // Cria cliente SEM CPF (IMPORTANTE)
        return CustomerEntityRepository::createCustomer([
            'customer_name'   => $data['name'] ?? 'Cliente',
            'customer_email'  => $data['email'],
            'customer_passwd' => Hash::make(str()->random(16)), // Senha gerada automaticamente
            'vat_number'      => null,
        ]);

    }

    /**
     * Logout do cliente
     */
    public function logout(): void
    {
        Auth::guard('customer')->logout();
        session()->invalidate();
        session()->regenerateToken();
    }

    /**
     * Cliente autenticado
     */
    public function user(): ?CustomerEntity
    {
        return Auth::guard('customer')->user();
    }

    /**
     * Verifica se cliente está autenticado
     */
    public function check(): bool
    {
        return Auth::guard('customer')->check();
    }

}


