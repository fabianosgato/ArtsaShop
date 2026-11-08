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
return [
    'name' => 'Payments',

    /**
     * Gateway padrão a ser usado
     * Opções: 'pagarme', 'ipag'
     */
    'gateway' => [
        'default' => env('PAYMENTS_GATEWAY_DEFAULT', 'ipag'),
    ],

    /**
     * Configurações do Pagar.me
     */
    'pagarme' => [
        'active' => env('PAGARME_ACTIVE', false),
        'environment' => env('PAGARME_ENVIRONMENT', 'sandbox'), // sandbox | production
        'base_url' => env('PAGARME_BASE_URL', 'https://api.pagar.me/core/v5'),

        // Sandbox
        'sandbox_account_id' => env('PAGARME_SANDBOX_ACCOUNT_ID'),
        'sandbox_public_key' => env('PAGARME_SANDBOX_PUBLIC_KEY'),
        'sandbox_secret_key' => env('PAGARME_SANDBOX_SECRET_KEY'),

        // Production
        'production_account_id' => env('PAGARME_PRODUCTION_ACCOUNT_ID'),
        'production_public_key' => env('PAGARME_PRODUCTION_PUBLIC_KEY'),
        'production_secret_key' => env('PAGARME_PRODUCTION_SECRET_KEY'),

        // Webhook
        'webhook_secret' => env('PAGARME_WEBHOOK_SECRET'),
    ],

    /**
     * Configurações do IPag
     */
    'ipag' => [
        'active' => env('IPAG_ACTIVE', false),
        'api_id' => env('IPAG_API_ID'),
        'api_key' => env('IPAG_API_KEY'),
        'api_env' => env('IPAG_API_ENV', 'sandbox'), // sandbox | production
        'webhook_secret' => env('IPAG_WEBHOOK_SECRET'),
    ],

    /**
     * Configurações de métodos de pagamento
     */
    'methods' => [
        'pix' => [
            'active' => true,
            'min_amount' => 100, // em centavos
            'max_amount' => 5000000,
        ],
        'credit_card' => [
            'active' => true,
            'min_amount' => 100,
            'max_amount' => 5000000,
            'max_installments' => 12,
            'min_installment_value' => 20000, // em centavos (R$ 200,00)
        ],
        'boleto' => [
            'active' => false,
            'min_amount' => 100,
            'max_amount' => 5000000,
        ],
        'debit_card' => [
            'active' => false,
        ],
    ],
];
