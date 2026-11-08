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

abstract class GatewayStatus
{
    /** A operação foi concluída com sucesso */
    public const string SUCCEED = 'P0';
    /** A operação não foi concluída devido à um erro */
    public const string FAILED_UNKNOWN = 'P1';
    /** A operação foi ABORTADA */
    public const string ABORTED = 'P2';
    /** A operação foi RECUSADA pelo processador de pagamentos devido a um limitador */
    public const string REFUSED_LIMITER = 'P3';
    /** A operação foi RECUSADA pelo processador de pagamentos */
    public const string REFUSED_UNKNOWN = 'P4';
    /** A transação está em quarentena */
    public const string QUARANTINE = 'P5';
    /** O cartão de informado expirou ou possui dados de vencimento incorretos  */
    public const string EXPIRED = 'P6';
    /** O cartão e/ou cliente informado estão/está na lista negra  */
    public const string BLACKLIST = 'P7';
    /** O processo foi iniciado  */
    public const string PROCESS_INITIALIZED = 'P9';
    /** A transação foi APROVADA automaticamente devido as regras de antifraude   */
    public const string TRANSACTION_ANTIFRAUD_SUCCEED = 'F0';
    /** A transação foi RECUSADA automaticamente devido as regras de antifraude   */
    public const string TRANSACTION_ANTIFRAUD_REFUSED = 'F1';
    /** A transação foi avaliada pelo antifraude, porém sua ação posterior falhou (captura/cancelamento)    */
    public const string TRANSACTION_ANTIFRAUD_FAILED = 'F2';
}
