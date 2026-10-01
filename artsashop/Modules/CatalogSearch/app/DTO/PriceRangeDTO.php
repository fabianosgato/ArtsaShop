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
namespace Modules\CatalogSearch\DTO;

readonly class PriceRangeDTO
{
    public function __construct(
        public readonly float $minPrice,
        public readonly float $maxPrice,
    )
    {
    }

    public function hasPrices(): bool
    {
        return $this->maxPrice > 0;
    }

}
