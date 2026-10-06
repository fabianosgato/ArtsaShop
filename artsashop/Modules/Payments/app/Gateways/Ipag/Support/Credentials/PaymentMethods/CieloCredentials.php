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
namespace Modules\Payments\Gateways\Ipag\Support\Credentials\PaymentMethods;

use Modules\Payments\Gateways\Ipag\Model\Model;
use Modules\Payments\Gateways\Ipag\Model\Schema\Schema;
use Modules\Payments\Gateways\Ipag\Model\Schema\SchemaBuilder;

/**
 * CieloCredentials Class
 *
 * Classe responsável pela credencial da identidade Cielo.
 */
final class CieloCredentials extends Model
{
    /**
     * @param array|null $data
     *  array de dados da credencial da Cielo.
     *
     *  + ['merchant_id'] string (opcional).
     *  + ['merchant_key'] string (opcional).
     * @throws \Exception
     */
    public function __construct(?array $data = [])
    {
        parent::__construct($data);
    }

    public function schema(SchemaBuilder $schema): Schema
    {
        $schema->string('merchant_id')->nullable();
        $schema->string('merchant_key')->nullable();

        return $schema->build();
    }

    /**
     * Retorna o valor da propriedade merchant_id.
     *
     * @return string|null
     */
    public function getMerchantId(): ?string
    {
        return $this->get('merchant_id');
    }

    /**
     * Seta o valor da propriedade merchant_id.
     *
     * @param string|null $merchantId
     * @return self
     */
    public function setMerchantId(?string $merchantId = null): self
    {
        $this->set('merchant_id', $merchantId);
        return $this;
    }

    /**
     * Retorna o valor da propriedade merchant_key.
     *
     * @return string|null
     */
    public function getMerchantKey(): ?string
    {
        return $this->get('merchant_key');
    }

    /**
     * Seta o valor da propriedade merchant_key.
     *
     * @param string|null $merchantKey
     * @return self
     */
    public function setMerchantKey(?string $merchantKey = null): self
    {
        $this->set('merchant_key', $merchantKey);
        return $this;
    }

}
