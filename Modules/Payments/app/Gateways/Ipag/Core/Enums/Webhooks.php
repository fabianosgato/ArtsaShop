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
namespace Modules\Payments\Gateways\Ipag\Core\Enums;

abstract class Webhooks
{
    /**
     * Link de Pagamento recebeu um pagamento aprovado.
     */
    public const string PAYMENT_LINK_PAYMENT_SUCCEEDED = 'PaymentLinkPaymentSucceeded';

    /**
     * Link de Pagamento recebeu um pagamento recusado.
     */
    public const string PAYMENT_LINK_PAYMENT_FAILED = 'PaymentLinkPaymentFailed';

    /**
     * O pagamento da Assinatura foi processado com sucesso.
     */
    public const string SUBSCRIPTION_PAYMENT_SUCCEEDED = 'SubscriptionPaymentSucceeded';

    /**
     * O pagamento da Assinatura foi processado com falha.
     */
    public const string SUBSCRIPTION_PAYMENT_FAILED = 'SubscriptionPaymentFailed';

    /**
     * O pagamento da Cobrança foi processado com sucesso.
     */
    public const string CHARGE_PAYMENT_SUCCEEDED = 'ChargePaymentSucceeded';

    /**
     * O pagamento da Cobrança foi processado com falha.
     */
    public const string CHARGE_PAYMENT_FAILED = 'ChargePaymentFailed';

    /**
     * A Transação foi criada.
     */
    public const string TRANSACTION_CREATED = 'TransactionCreated';

    /**
     * Transação aguardando pagamento do boleto.
     */
    public const string TRANSACTION_WAITING_PAYMENT = 'TransactionWaitingPayment';

    /**
     * A Transação foi cancelada com sucesso.
     */
    public const string TRANSACTION_CANCELED = 'TransactionCanceled';

    /**
     * A Transação foi Pré-Autorizada com sucesso.
     */
    public const string TRANSACTION_PRE_AUTHORIZED = 'TransactionPreAuthorized';

    /**
     * A Transação foi Capturada com sucesso.
     */
    public const string TRANSACTION_CAPTURED = 'TransactionCaptured';

    /**
     * A Transação teve a autorização recusada pela Adquirente.
     */
    public const string TRANSACTION_DENIED = 'TransactionDenied';

    /**
     * A Transação sofreu disputa do Pagador/Cliente.
     */
    public const string TRANSACTION_DISPUTED = 'TransactionDisputed';

    /**
     * A Transação foi Estornada, e o valor devolvido ao Pagador/Cliente.
     */
    public const string TRANSACTION_CHARGEDBACK = 'TransactionChargedback';

    /**
     * A Transferência foi realizada com sucesso.
     */
    public const string TRANSFER_PAYMENT_SUCCEEDED = 'TransferPaymentSucceeded';

    /**
     * A Transferência foi realizada com falha.
     */
    public const string TRANSFER_PAYMENT_FAILED = 'TransferPaymentFailed';
}
