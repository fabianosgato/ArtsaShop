<?php
/**
 * Lef Tecnologia
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
 * @copyright    Copyright (c) 2010 - 2025 Fabiano Gato
 * @author       Fabiano Gato <fabiano@lef-tecnologia.com.br>
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
