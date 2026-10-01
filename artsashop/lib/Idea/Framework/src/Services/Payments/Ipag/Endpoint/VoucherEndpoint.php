<?php

namespace Idea\Framework\Services\Payments\Ipag\Endpoint;

use Idea\Framework\Services\Payments\Ipag\Core\Endpoint;
use Idea\Framework\Services\Payments\Ipag\Http\Response;
use Idea\Framework\Services\Payments\Ipag\Model\Voucher;


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
     * Endpoint para criar um novo recurso `Voucher`
     *
     * @param Voucher $voucher
     * @return Response
     */
    public function create(Voucher $voucher): Response
    {
        return $this->_POST($voucher->jsonSerialize());
    }

}
