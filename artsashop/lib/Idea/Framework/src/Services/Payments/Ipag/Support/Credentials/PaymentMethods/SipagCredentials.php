<?php

namespace Idea\Framework\Services\Payments\Ipag\Support\Credentials\PaymentMethods;

use Idea\Framework\Services\Payments\Ipag\Model\Model;
use Idea\Framework\Services\Payments\Ipag\Model\Schema\Schema;
use Idea\Framework\Services\Payments\Ipag\Model\Schema\SchemaBuilder;

/**
 * SipagCredentials Class
 *
 * Classe responsável pela credencial da identidade `Sipag`.
 */
final class SipagCredentials extends Model
{
    /**
     * @param array $data
     *  array de dados da credencial da Sipag.
     *
     *  + [`'store_id_subscription'`] string (opcional).
     *  + [`'store_id'`] string (opcional).
     *
     */
    public function __construct(?array $data = [])
    {
        parent::__construct($data);
    }

    public function schema(SchemaBuilder $schema): Schema
    {
        $schema->string('store_id_subscription')->nullable();
        $schema->string('store_id')->nullable();

        return $schema->build();
    }

    /**
     * Retorna o valor da propriedade `store_id_subscription`.
     *
     * @return string|null
     */
    public function getStoreIdSubscription(): ?string
    {
        return $this->get('store_id_subscription');
    }

    /**
     * Seta o valor da propriedade `store_id_subscription`.
     *
     * @param string|null $storeIdSubscription
     * @return self
     */
    public function setStoreIdSubscription(?string $storeIdSubscription = null): self
    {
        $this->set('store_id_subscription', $storeIdSubscription);
        return $this;
    }

    /**
     * Retorna o valor da propriedade `store_id`.
     *
     * @return string|null
     */
    public function getStoreId(): ?string
    {
        return $this->get('store_id');
    }

    /**
     * Seta o valor da propriedade `store_id`.
     *
     * @param string|null $storeId
     * @return self
     */
    public function setStoreId(?string $storeId = null): self
    {
        $this->set('store_id', $storeId);
        return $this;
    }

}
