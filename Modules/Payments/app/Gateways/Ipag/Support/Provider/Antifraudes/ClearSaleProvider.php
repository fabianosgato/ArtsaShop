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
namespace Modules\Payments\Gateways\Ipag\Support\Provider\Antifraudes;

use Modules\Payments\Gateways\Ipag\Model\Model;
use Modules\Payments\Gateways\Ipag\Model\Schema\Schema;
use Modules\Payments\Gateways\Ipag\Model\Schema\SchemaBuilder;
use Modules\Payments\Gateways\Ipag\Support\Credentials\Antifraudes\ClearSaleCredentials;

/**
 * ClearSaleProvider Class
 *
 * Classe responsável pelo provider da identidade ClearSale.
 */
final class ClearSaleProvider extends Model
{
    /**
     * @param array|null $data
     *  array de dados do Clear Sale Credentials.
     *
     *  + ['name'] string (opcional).
     *  + ['password'] string (opcional).
     * @throws \Exception
     */
    public function __construct(?array $data = null)
    {
        parent::__construct([
            'name' => 'clearsale',
            'credentials' => $data
        ]);
    }

    public function schema(SchemaBuilder $schema): Schema
    {
        $schema->string('name')->default('clearsale')->nullable();
        $schema->has('credentials', ClearSaleCredentials::class)->nullable();

        return $schema->build();
    }

    /**
     * Retorna o valor da propriedade name.
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->get('name');
    }

    /**
     * Retorna o valor da propriedade credentials.
     *
     * @return ClearSaleCredentials|null
     */
    public function getCredentials(): ?ClearSaleCredentials
    {
        return $this->get('credentials');
    }

    /**
     * Seta o valor da propriedade credentials.
     *
     * @param ClearSaleCredentials|null $credentials
     * @return self
     */
    public function setCredentials(?ClearSaleCredentials $credentials = null): self
    {
        $this->set('credentials', $credentials);
        return $this;
    }

}
