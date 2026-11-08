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
 * RedeCredentials Class
 *
 * Classe responsável pela credencial da identidade Rede.
 */
final class RedeCredentials extends Model
{
    /**
     * @param array|null $data
     *  array de dados da credencial da Rede.
     *
     *  + ['erede_key'] string (opcional).
     *  + ['pv'] string (opcional).
     * @throws \Exception
     */
    public function __construct(?array $data = [])
    {
        parent::__construct($data);
    }

    public function schema(SchemaBuilder $schema): Schema
    {
        $schema->string('erede_key')->nullable();
        $schema->string('pv')->nullable();

        return $schema->build();
    }

    /**
     * Retorna o valor da propriedade erede_key.
     *
     * @return string|null
     */
    public function getEredeKey(): ?string
    {
        return $this->get('erede_key');
    }

    /**
     * Seta o valor da propriedade erede_key.
     *
     * @param string|null $eredeKey
     * @return self
     */
    public function setEredeKey(?string $eredeKey = null): self
    {
        $this->set('erede_key', $eredeKey);
        return $this;
    }

    /**
     * Retorna o valor da propriedade pv.
     *
     * @return string|null
     */
    public function getPv(): ?string
    {
        return $this->get('pv');
    }

    /**
     * Seta o valor da propriedade pv.
     *
     * @param string|null $pv
     * @return self
     */
    public function setPv(?string $pv = null): self
    {
        $this->set('pv', $pv);
        return $this;
    }

}
