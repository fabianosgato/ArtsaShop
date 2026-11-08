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
namespace Modules\Payments\Gateways\Ipag\Endpoint;

use Modules\Payments\Gateways\Ipag\Core\Endpoint;
use Modules\Payments\Gateways\Ipag\Http\Response;
use Modules\Payments\Gateways\Ipag\Model\Voucher;


/**
 * VoucherEndpoint class
 *
 * Classe responsável pelo controle dos endpoints do recurso Voucher.
 *
 */
class VoucherEndpoint extends Endpoint
{
    protected string $location = '/service/resources/vouchers';

    /**
     * Endpoint para criar um recurso Voucher
     *
     * @param Voucher $voucher
     * @return Response
     */
    public function create(Voucher $voucher): Response
    {
        return $this->_POST($voucher->jsonSerialize());
    }

}
