<?php

namespace Idea\Framework\Services\Payments\Ipag\Model;

use DateTime;
use Idea\Framework\Services\Payments\Ipag\Model\Schema\Mutator;
use Idea\Framework\Services\Payments\Ipag\Model\Schema\Schema;
use Idea\Framework\Services\Payments\Ipag\Model\Schema\SchemaBuilder;
use Kubinyete\Assertation\Assert;

/**
 * Holder Class
 *
 * Classe responsável por representar o recurso Holder.
 *
 */
class Holder extends Model
{

    /**
     * @param array $data
     *  array de dados do Holder.
     *
     *  + [`'name'`] string.
     *  + [`'cpfCnpj'`] string.
     *  + [`'mobilePhone'`] string.
     *  + [`'birthdate'`] string.
     *  + [`'address'`] array (opcional) dos dados do Address.
     *  + &emsp; [`'street'`] string (opcional).
     *  + &emsp; [`'number'`] string (opcional).
     *  + &emsp; [`'district'`] string (opcional).
     *  + &emsp; [`'city'`] string (opcional).
     *  + &emsp; [`'state'`] string (opcional).
     *  + &emsp; [`'zipcode'`] string (opcional).
     */
    public function __construct(?array $data = [])
    {
        parent::__construct($data);
    }

    /**
     * Retorna o valor da propriedade `name`.
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->get('name');
    }

    /**
     * Seta o valor da propriedade `name`.
     *
     * @param string|null $name
     * @return self
     */
    public function setName(?string $name = null): self
    {
        $this->set('name', $name);
        return $this;
    }

    /**
     * Retorna o valor da propriedade `cpfCnpj`.
     *
     * @return string|null
     */
    public function getCpfCnpj(): ?string
    {
        return $this->get('cpfCnpj');
    }

    /**
     * Seta o valor da propriedade `cpfCnpj`.
     *
     * @param string|null $cpfCnpj
     * @return self
     */
    public function setCpfCnpj(?string $cpfCnpj = null): self
    {
        $this->set('cpfCnpj', $cpfCnpj);
        return $this;
    }

    /**
     * Retorna o valor da propriedade `mobilePhone`.
     *
     * @return string|null
     */
    public function getMobilePhone(): ?string
    {
        return $this->get('mobilePhone');
    }

    /**
     * Seta o valor da propriedade `mobilePhone`.
     *
     * @param string|null $phone
     * @return self
     */
    public function setMobilePhone(?string $phone = null): self
    {
        $this->set('mobilePhone', $phone);
        return $this;
    }

    /**
     * Retorna o valor da propriedade `birthdate`.
     *
     * @return string|null
     */
    public function getBirthdate(): ?string
    {
        return $this->get('birthdate');
    }

    /**
     * Seta o valor da propriedade `birthdate`.
     *
     * @param string|null $birthdate
     * @return self
     */
    public function setBirthdate(?string $birthdate = null): self
    {
        $this->set('birthdate', $birthdate);
        return $this;
    }

    /**
     * Retorna o objeto endereço do cliente.
     *
     * @return Address|null
     */
    public function getAddress(): ?Address
    {
        return $this->get('address');
    }

    /**
     * Seta o objeto endereço do cliente.
     *
     * @param Address|null $address
     * @return self
     */
    public function setAddress(?Address $address = null): self
    {
        $this->set('address', $address);
        return $this;
    }

    protected function schema(SchemaBuilder $schema): Schema
    {
        $schema->string('name')->nullable();
        $schema->string('cpfCnpj')->nullable();
        $schema->string('mobilePhone')->nullable();
        $schema->string('birthdate')->nullable();

        $schema->has('address', Address::class)->nullable();

        return $schema->build();
    }

    protected function cpfCnpj(): Mutator
    {
        return new Mutator(
            null,
            fn($value, $ctx) => is_null($value) ?
                $value :
                Assert::value($value)->asCpf(false)->or()->asCnpj(false)->get() ?? $ctx->raise('inválido')
        );
    }

    protected function mobilePhone(): Mutator
    {
        return new Mutator(
            null,
            fn($value, $ctx) => is_null($value) ?
                $value :
                Assert::value($value)->asDigits()->lbetween(10, 11)->get() ?? $ctx->raise('inválido')
        );
    }

    protected function birthdate(): Mutator
    {
        return new Mutator(
            null,
            function ($value, $ctx) {
                $d = DateTime::createFromFormat('Y-m-d', $value);

                return is_null($value) ||
                ($d && $d->format('Y-m-d') === $value) ?
                    $value : $ctx->raise('inválido');
            }
        );
    }

}
