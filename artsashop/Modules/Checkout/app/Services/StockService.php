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
