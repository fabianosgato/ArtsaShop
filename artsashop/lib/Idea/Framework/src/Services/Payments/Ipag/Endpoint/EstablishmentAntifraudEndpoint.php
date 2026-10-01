<?php

namespace Idea\Framework\Services\Payments\Ipag\Endpoint;

use Idea\Framework\Services\Payments\Ipag\Core\Endpoint;
use Idea\Framework\Services\Payments\Ipag\Http\Response;
use Idea\Framework\Services\Payments\Ipag\Model\Antifraud;

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
            "/{$establishmentUuid}/antifraud_settings"
        );
    }

}
