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

declare(strict_types=1);

namespace Modules\Payments\Gateways\Pagarme;

use Modules\Payments\Gateways\Pagarme\Core\PagarmeClient;
use RuntimeException;

class PagarmeRecipient
{

    /**
     * Client da API Pagar.me.
     */
    protected PagarmeClient $client;

    /**
     * Inicializa o serviço de recebedores.
     */
    public function __construct(
        PagarmeClient $client
    )
    {

        $this->client = $client;

    }

    /**
     * Cria um recebedor para a clínica.
     */
    public function create(
        ClinicsEntity $clinic
    ): array
    {

        // Retorna a conta financeira da clínica.
        $paymentAccount = ClinicPaymentAccountRepository::getByClinicId(
            clinicId: $clinic->clinic_id
        );

        if (!$paymentAccount) {

            throw new RuntimeException(
                'A clínica não possui uma conta financeira cadastrada.'
            );

        }

        // Verifica se já existe um recebedor cadastrado.
        if (filled($paymentAccount->recipient_id)) {

            throw new RuntimeException(
                'A clínica já possui um recebedor Pagar.me cadastrado.'
            );

        }

        // Monta o payload.
        $payload = $this->buildPayload(
            clinic: $clinic,
            paymentAccount: $paymentAccount
        );

        // Cria o recebedor no Pagar.me.
        $response = $this->client->post(
            uri: '/recipients',
            data: $payload
        );

        $recipient = $response->json();

        // Verifica se o Pagar.me retornou o ID do recebedor.
        if (blank($recipient['id'] ?? null)) {

            throw new RuntimeException(
                'O Pagar.me não retornou o ID do recebedor.'
            );

        }

        // Persiste o recipient_id.
        ClinicPaymentAccountRepository::updateRecipientId(
            clinicId: $clinic->clinic_id,
            recipientId: $recipient['id']
        );

        return $recipient;

    }

    /**
     * Monta o payload para criação do recebedor.
     */
    protected function buildPayload(
        ClinicsEntity $clinic,
        ClinicPaymentAccount $paymentAccount
    ): array
    {

        return [
            'name' => $clinic->clinic_legal_name,

            'email' => $clinic->clinic_email,

            'description' => sprintf(
                'Recebedor %s',
                $clinic->clinic_name
            ),

            'document' => $this->onlyNumbers(
                $clinic->clinic_document
            ),

            'type' => 'company',

            'default_bank_account' => [
                'holder_name' => $paymentAccount->account_holder_name,

                'holder_type' => 'company',

                'holder_document' => $this->onlyNumbers(
                    $paymentAccount->account_holder_document
                ),

                'bank' => $paymentAccount->bank_code,

                'branch_number' => $paymentAccount->agency,

                'branch_check_digit' => $paymentAccount->agency_digit,

                'account_number' => $paymentAccount->account_number,

                'account_check_digit' => $paymentAccount->account_digit,

                'type' => $paymentAccount->account_type,
            ],

            'transfer_settings' => [
                'transfer_enabled' => true,

                'transfer_interval' => 'Monthly',

                'transfer_day' => '30',
            ],

            'automatic_anticipation_settings' => [
                'enables' => false,

                'type' => '1025',

                'volume_percentage' => '100',

                'days' => range(1, 31),

                'delay' => '30',
            ],

            'metadata' => [
                'clinic_id' => (string) $clinic->clinic_id,
            ],
        ];

    }

    /**
     * Retorna somente os números de um valor.
     */
    protected function onlyNumbers(
        ?string $value
    ): string
    {

        return preg_replace(
            '/\D/',
            '',
            (string) $value
        );

    }

}
