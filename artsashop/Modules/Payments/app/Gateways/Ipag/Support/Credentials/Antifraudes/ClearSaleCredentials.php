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
 * ClearSaleCredentials Class
 *
 * Classe responsável pela credencial a identidade Clear Sale.
 */
final class ClearSaleCredentials extends Model
{
    /**
     * @param array|null $data
     *  array de dados do Clear Sale.
     *
     *  + ['name'] string (opcional).
     *  + ['password'] string (opcional).
     * @throws \Exception
     */
    public function __construct(?array $data = [])
    {
        parent::__construct($data);
    }

    public function schema(SchemaBuilder $schema): Schema
    {
        $schema->string('name')->nullable();
        $schema->string('password')->nullable();

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
     * Seta o valor da propriedade name.
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
     * Retorna o valor da propriedade password.
     *
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->get('password');
    }

    /**
     * Seta o valor da propriedade password.
     *
     * @param string|null $password
     * @return self
     */
    public function setPassword(?string $password = null): self
    {
        $this->set('password', $password);
        return $this;
    }

}
