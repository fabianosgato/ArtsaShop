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
namespace Idea\Framework\Jobs;

use Idea\Framework\Repository\Eav\EavAttributeSetRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class UpdateAttributeSetProductJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public int $attributeSetId)
    {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Atualiza todos os produtos pelo Grupo de Atributos
        EavAttributeSetRepository::updateAllProducts(
            attributeSetId: $this->attributeSetId
        );
    }

}
