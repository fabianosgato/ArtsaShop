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
use Modules\Payments\Gateways\Ipag\Model\Antifraud;

/**
 * EstablishmentAntifraudEndpoint class
 *
 * Classe responsável pelo controle dos endpoints do recurso Establishment Antifraud.
 *
 */
class EstablishmentAntifraudEndpoint extends Endpoint
{
    protected string $location = '/service/v2/establishments';

    /**
     * Endpoint para configuração de antifraude
     *
     * @param Antifraud $antifraud
     * @param string $establishmentUuid
     * @return Response
     */
    public function config(Antifraud $antifraud, string $establishmentUuid): Response
    {
        return $this->_POST(
            $antifraud->jsonSerialize(),
            [],
            [],
            "/$establishmentUuid/antifraud_settings"
        );
    }

}
