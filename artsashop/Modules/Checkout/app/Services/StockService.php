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
namespace Modules\Checkout\Services;

use Idea\Framework\Repository\Catalog\CatalogProductsRepository;

class StockService
{

    /**
     * Realiza as validações do produto antes de adicioná-lo ao carrinho
     * @param int $productId
     * @param int $qty
     * @return void
     */
    public function validate(int $productId, int $qty): void
    {

        $product = CatalogProductsRepository::getProductById($productId);

        if (!$product) {
            throw new \DomainException('Produto não encontrado.');
        }

        if ($product->qty < $qty) {
            throw new \DomainException(
                "Estoque insuficiente para {$product->name}."
            );
        }

    }


}
