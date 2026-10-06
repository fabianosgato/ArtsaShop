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
namespace Modules\Payments\Gateways\Ipag\Support\Credentials\Antifraudes;

use Modules\Payments\Gateways\Ipag\Model\Model;
use Modules\Payments\Gateways\Ipag\Model\Schema\Schema;
use Modules\Payments\Gateways\Ipag\Model\Schema\SchemaBuilder;

/**
 * KondutoCredentials Class
 *
 * Classe responsável pela credencial a identidade Konduto.
 */
final class KondutoCredentials extends Model
{
    /**
     * @param array|null $data
     *  array de dados do Clear Sale.
     *
     *  + ['apiKey'] string (opcional).
     *  + ['publicKey'] string (opcional).
     * @throws \Exception
     */
    public function __construct(?array $data = [])
    {
        parent::__construct($data);
    }

    public function schema(SchemaBuilder $schema): Schema
    {
        $schema->string('apiKey')->nullable();
        $schema->string('publicKey')->nullable();

        return $schema->build();
    }

    /**
     * Retorna o valor da propriedade apiKey.
     *
     * @return string|null
     */
    public function getApiKey(): ?string
    {
        return $this->get('apiKey');
    }

    /**
     * Seta o valor da propriedade apiKey.
     *
     * @param string|null $apiKey
     * @return self
     */
    public function setApiKey(?string $apiKey = null): self
    {
        $this->set('apiKey', $apiKey);
        return $this;
    }

    /**
     * Retorna o valor da propriedade publicKey.
     *
     * @return string|null
     */
    public function getPublicKey(): ?string
    {
        return $this->get('publicKey');
    }

    /**
     * Seta o valor da propriedade publicKey.
     *
     * @param string|null $publicKey
     * @return self
     */
    public function setPublicKey(?string $publicKey = null): self
    {
        $this->set('publicKey', $publicKey);
        return $this;
    }

}
