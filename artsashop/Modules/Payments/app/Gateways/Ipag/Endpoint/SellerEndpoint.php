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
use Modules\Payments\Gateways\Ipag\Model\Seller;

/**
 * SellerEndpoint class
 *
 * Classe responsável pelo controle dos endpoints do recurso Seller.
 */
class SellerEndpoint extends Endpoint
{
    protected string $location = '/service/resources/sellers';

    /**
     * Endpoint para criar um recurso Seller
     *
     * @param Seller $seller
     * @return Response
     */
    public function create(Seller $seller): Response
    {
        return $this->_POST($seller->jsonSerialize());
    }

    /**
     * Endpoint para atualizar um recurso Seller
     *
     * @param Seller $seller
     * @param integer $id
     * @return Response
     *
     * @codeCoverageIgnore
     */
    public function update(Seller $seller, int $id): Response
    {
        return $this->_PUT($seller, ['id' => $id]);
    }

    /**
     * Endpoint para obter um recurso Seller
     *
     * @param integer $id
     * @return Response
     *
     * @codeCoverageIgnore
     */
    public function get(int $id): Response
    {
        return $this->_GET(['id' => $id]);
    }

    /**
     * Endpoint para listar recursos Seller
     *
     * @param array|null $filters
     * @return Response
     *
     * @codeCoverageIgnore
     */
    public function list(?array $filters = []): Response
    {
        return $this->_GET($filters ?? []);
    }

}
