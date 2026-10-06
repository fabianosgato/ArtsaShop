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
namespace Modules\Payments\Gateways\Ipag\Model;

use Kubinyete\Assertation\Assert;
use Modules\Payments\Gateways\Ipag\Model\Schema\Mutator;
use Modules\Payments\Gateways\Ipag\Model\Schema\Schema;
use Modules\Payments\Gateways\Ipag\Model\Schema\SchemaBuilder;

/**
 * Buttons Class
 *
 * Classe responsável por representar o recurso Buttons.
 */
class Buttons extends Model
{
    /**
     * @param array $data
     *  array de dados do Buttons.
     *
     *  + ['enable'] bool (opcional).
     *  + ['one'] float (opcional).
     *  + ['two'] float (opcional).
     *  + ['three'] float (opcional).
     *  + ['description'] string (opcional).
     *  + ['header'] string (opcional).
     *  + ['subHeader'] string (opcional).
     *  + ['expireAt'] string (opcional) {Formato: Y-m-d H:i:s}.
     */
    public function __construct(?array $data = [])
    {
        parent::__construct($data);
    }

    public function getEnable(): ?bool
    {
        return $this->get('enable');
    }

    public function setEnable(?bool $enable): self
    {
        $this->set('enable', $enable);
        return $this;
    }

    public function getOne(): ?float
    {
        return $this->get('one');
    }

    public function setOne(?float $one): self
    {
        $this->set('one', $one);
        return $this;
    }

    public function getTwo(): ?float
    {
        return $this->get('two');
    }

    public function setTwo(?float $two): self
    {
        $this->set('two', $two);
        return $this;
    }

    public function getThree(): ?float
    {
        return $this->get('three');
    }

    public function setThree(?float $three): self
    {
        $this->set('three', $three);
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->get('description');
    }

    public function setDescription(?string $description): self
    {
        $this->set('description', $description);
        return $this;
    }

    public function getHeader(): ?string
    {
        return $this->get('header');
    }

    public function setHeader(?string $header): self
    {
        $this->set('header', $header);
        return $this;
    }

    public function getSubHeader(): ?string
    {
        return $this->get('subHeader');
    }

    public function setSubHeader(?string $subHeader): self
    {
        $this->set('subHeader', $subHeader);
        return $this;
    }

    public function getExpireAt(): ?string
    {
        return $this->get('expireAt');
    }

    public function setExpireAt(?string $expireAt): self
    {
        $this->set('expireAt', $expireAt);
        return $this;
    }

    protected function schema(SchemaBuilder $schema): Schema
    {
        $schema->bool('enable')->nullable();
        $schema->float('one')->nullable();
        $schema->float('two')->nullable();
        $schema->float('three')->nullable();
        $schema->string('description')->nullable();
        $schema->string('header')->nullable();
        $schema->string('subHeader')->nullable();
        $schema->string('expireAt')->nullable();

        return $schema->build();
    }

    protected function one(): Mutator
    {
        return new Mutator(
            null,
            fn($value, $ctx) => is_null($value) ? $value :
                (
                    Assert::value(floatval($value))->gte(0)->get()
                    ?? $ctx->raise('inválido')
                )
        );
    }

    protected function two(): Mutator
    {
        return new Mutator(
            null,
            fn($value, $ctx) => is_null($value) ? $value :
                (
                    Assert::value(floatval($value))->gte(0)->get()
                    ?? $ctx->raise('inválido')
                )
        );
    }

    protected function three(): Mutator
    {
        return new Mutator(
            null,
            fn($value, $ctx) => is_null($value) ? $value :
                (
                    Assert::value(floatval($value))->gte(0)->get()
                    ?? $ctx->raise('inválido')
                )
        );
    }

}
