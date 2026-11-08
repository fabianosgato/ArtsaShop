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
namespace Modules\Payments\Gateways\Ipag\Model;

use Modules\Payments\Gateways\Ipag\Model\Schema\Schema;
use Modules\Payments\Gateways\Ipag\Model\Schema\SchemaBuilder;

/**
 * Antifraud Class
 *
 * Classe responsável por representar o recurso Antifraud.
 */
class Antifraud extends Model
{

    /**
     * @param array|null $data
     * array de dados do recurso Antifraud
     *
     *  + ['provider'] array (opcional) dos dados do Address.
     *  + &emsp; ['name'] string (opcional).
     *  + &emsp; ['credentials'] array (opcional).
     *  + ['settings'] array (opcional) dos dados do Address.
     *  + &emsp; ['enabled'] bool (opcional).
     *  + &emsp; ['environment'] enum {'production' | 'test'} (opcional).
     *  + &emsp; ['consult_mode'] enum {'auto' | 'manual'} (opcional).
     *  + &emsp; ['capture_on_approval'] bool (opcional).
     *  + &emsp; ['cancel_on_refused'] bool (opcional).
     *  + &emsp; ['review_score_threshold'] float (opcional).
     *
     * @throws \Exception
     */
    public function __construct(?array $data = [])
    {
        parent::__construct($data);
    }

    /**
     * Retorna o valor da propriedade provider.
     *
     * @return AntifraudProvider|null
     */
    public function getProvider(): ?AntifraudProvider
    {
        return $this->get('provider');
    }

    /**
     * Seta o valor da propriedade provider.
     *
     * @param AntifraudProvider|null $provider
     * @return self
     */
    public function setProvider(?AntifraudProvider $provider = null): self
    {
        $this->set('provider', $provider);
        return $this;
    }

    /**
     * Retorna o valor da propriedade settings.
     *
     * @return AntifraudSettings|null
     */
    public function getSettings(): ?AntifraudSettings
    {
        return $this->get('settings');
    }

    /**
     * Seta o valor da propriedade settings.
     *
     * @param AntifraudSettings|null $settings
     * @return self
     */
    public function setSettings(?AntifraudSettings $settings = null): self
    {
        $this->set('settings', $settings);
        return $this;
    }

    protected function schema(SchemaBuilder $schema): Schema
    {
        $schema->has('provider', AntifraudProvider::class)->nullable();
        $schema->has('settings', AntifraudSettings::class)->nullable();

        return $schema->build();
    }

}
