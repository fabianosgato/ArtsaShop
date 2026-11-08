<?php
/**
 * Fabiano Gato
 *
 * NOTICE OF LICENSE
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 *
 * É concedida permissão, gratuitamente, a qualquer pessoa que obtenha uma cópia
 * deste software e arquivos de documentação associados
 *
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
 * StoneCredentials Class
 *
 * Classe responsável pela credencial da identidade Stone.
 */
final class StoneCredentials extends Model
{
    /**
     * @param array|null $data
     *  array de dados da credencial da Stone.
     *
     *  + ['stone_code'] string (opcional).
     *  + ['stone_sak'] string (opcional).
     * @throws \Exception
     */
    public function __construct(?array $data = [])
    {
        parent::__construct($data);
    }

    public function schema(SchemaBuilder $schema): Schema
    {
        $schema->string('stone_code')->nullable();
        $schema->string('stone_sak')->nullable();

        return $schema->build();
    }

    /**
     * Retorna o valor da propriedade stone_code.
     *
     * @return string|null
     */
    public function getStoneCode(): ?string
    {
        return $this->get('stone_code');
    }

    /**
     * Seta o valor da propriedade stone_code.
     *
     * @param string|null $stoneCode
     * @return self
     */
    public function setStoneCode(?string $stoneCode = null): self
    {
        $this->set('stone_code', $stoneCode);
        return $this;
    }

    /**
     * Retorna o valor da propriedade stone_sak.
     *
     * @return string|null
     */
    public function getStoneSak(): ?string
    {
        return $this->get('stone_sak');
    }

    /**
     * Seta o valor da propriedade stone_sak.
     *
     * @param string|null $stoneSak
     * @return self
     */
    public function setStoneSak(?string $stoneSak = null): self
    {
        $this->set('stone_sak', $stoneSak);
        return $this;
    }

}
