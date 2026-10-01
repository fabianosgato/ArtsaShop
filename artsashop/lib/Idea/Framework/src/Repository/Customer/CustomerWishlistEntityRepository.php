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
declare(strict_types=1);

namespace Idea\Framework\Repository\Customer;

use App\Models\CustomerWishlistEntity;
use Idea\Framework\Repository\AbstractRepository;
use Idea\Framework\Repository\Catalog\CatalogProductsRepository;

class CustomerWishlistEntityRepository extends AbstractRepository
{

    protected static $model = CustomerWishlistEntity::class;

    /**
     * Adiciona um produto a Wishlist do Cliente
     * @param $customerId
     * @param $productId
     * @return void
     */
    public static function add($customerId, $productId): void
    {

        // Valida se existe o Favorito
        $wishlist = self::checkIsWishlist(
            customerId: $customerId,
            productId: $productId
        );

        if ($wishlist) {
            // Apenas atualiza os dados
            self::getData()->find($wishlist->wishlist_id)
                ->update([
                    'product_id' => $productId
                ]);

        } else {
            self::getData()->create([
                'customer_id' => $customerId,
                'product_id' => $productId
            ]);

        }

    }

    /**
     * Adiciona um produto a Wishlist do Cliente
     * @param $customerId
     * @param $productId
     * @return void
     */
    public static function remove($customerId, $productId): void
    {

        // Valida se existe o Favorito
        $wishlist = self::checkIsWishlist(
            customerId: $customerId,
            productId: $productId
        );

        if ($wishlist) {
            // Remove o favorito
            self::getData()->find($wishlist->wishlist_id)->delete();
        }

    }

    /**
     * Retorna se o produto está na Wishlist
     * @param $customerId
     * @param $productId
     * @return false|null
     */
    public static function checkIsWishlist($customerId, $productId)
    {

        $query = self::getData()
            ->where(
                column: 'customer_id',
                operator: '=',
                value: $customerId
            )
            ->where(
                column: 'product_id',
                operator: '=',
                value: $productId
            );

        if ($query->exists())
            return $query->first();

        return false;

    }

    public static function getProduts($customerId): ?\Illuminate\Database\Eloquent\Collection
    {

        // Inicializa a query de produtos
        $query = CatalogProductsRepository::getData();

        // Realiza o join na tabela customer_wishlist_entity
        $query->join(
            table: 'customer_wishlist_entity',
            first: 'customer_wishlist_entity.product_id',
            operator: '=',
            second: 'catalog_product.product_id'
        );

        $query->where(
            column: 'customer_wishlist_entity.customer_id',
            operator: '=',
            value: $customerId
        );

        if ($query->exists())
            return $query->get();

        return null;

    }


}
