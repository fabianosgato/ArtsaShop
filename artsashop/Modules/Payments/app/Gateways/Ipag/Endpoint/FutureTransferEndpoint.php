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
namespace Modules\Payments\Gateways\Ipag\Endpoint;

use Modules\Payments\Gateways\Ipag\Core\Endpoint;
use Modules\Payments\Gateways\Ipag\Http\Response;

/**
 * TransferEndpoint class
 *
 * Classe responsável pelo controle dos endpoints do recurso Future Transfer.
 *
 */
class FutureTransferEndpoint extends Endpoint
{
    protected string $location = '/service/resources/future_transfers';

    /**
     * Endpoint para listar recursos Future Transfer
     *
     * @param array|null $filters
     * @return Response
     */
    public function list(?array $filters = []): Response
    {
        return $this->_GET($filters ?? []);
    }

    /**
     * Endpoint para listar recursos Future Transfer vinculado a um Seller (Pesquisar por Id)
     *
     * @param integer $sellerId
     * @return Response
     *
     * @codeCoverageIgnore
     */
    public function listBySellerId(int $sellerId): Response
    {
        return $this->_GET(['seller_id' => $sellerId]);
    }

    /**
     * Endpoint para listar recursos Future Transfer vinculado a um Seller (Pesquisar por CpfCnpj)
     *
     * @param string $sellerCpfCnpj
     * @return Response
     *
     * @codeCoverageIgnore
     */
    public function listBySellerCpfCnpj(string $sellerCpfCnpj): Response
    {
        return $this->_GET(['cpf_cnpj' => $sellerCpfCnpj]);
    }

}
