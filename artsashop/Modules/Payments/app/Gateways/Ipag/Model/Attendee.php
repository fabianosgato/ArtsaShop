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

use DateTime;
use Modules\Payments\Gateways\Ipag\Model\Schema\Mutator;
use Modules\Payments\Gateways\Ipag\Model\Schema\Schema;
use Modules\Payments\Gateways\Ipag\Model\Schema\SchemaBuilder;

/**
 * Attendee Class
 *
 * Classe responsável por representar o recurso Attendee.
 *
 */
final class Attendee extends Model
{
    /**
     * @param array $data
     *  array de dados do Attendee.
     *
     *  + ['document'] string (opcional).
     *  + ['dob'] string (opcional) {Formato: Y-m-d}.
     */
    public function __construct(?array $data = [])
    {
        parent::__construct($data);
    }

    public function schema(SchemaBuilder $schema): Schema
    {
        $schema->string('document')->nullable();
        $schema->string('dob')->nullable();

        return $schema->build();
    }

    /**
     * Retorna o valor da propriedade document.
     *
     * @return string|null
     */
    public function getDocument(): ?string
    {
        return $this->get('document');
    }

    /**
     * Seta o valor da propriedade document.
     *
     * @param string|null $document
     * @return self
     */
    public function setDocument(?string $document = null): self
    {
        $this->set('document', $document);
        return $this;
    }

    /**
     * Retorna o valor da propriedade dob.
     *
     * @return string|null
     */
    public function getDob(): ?string
    {
        return $this->get('dob');
    }

    /**
     * Seta o valor da propriedade dob.
     *
     * @param string|null $dob
     * @return self
     */
    public function setDob(?string $dob = null): self
    {
        $this->set('dob', $dob);
        return $this;
    }

    protected function dob(): Mutator
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
