<?php

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
     * Endpoint para criar um novo recurso Voucher
     *
     * @param Voucher $voucher
     * @return Response
     */
    public function create(Voucher $voucher): Response
    {
        return $this->_POST($voucher->jsonSerialize());
    }

}
