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

namespace Tests\Feature\Idea\Modules;

use App\Models\CustomerEntity;
use App\Models\Review;
use Idea\Framework\Repository\Catalog\CatalogProductsRepository;
use Idea\Framework\Repository\Reviews\ReviewEntityRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Modules\Review\Enums\ReviewStatus;
use Modules\Review\Services\ReviewService;
use Tests\TestCase;

class ReviewServiceTest extends TestCase
{

    public function testCreateReview()
    {

        // Cria um customer
        $customer = CustomerEntity::factory()->create([
            'customer_name' => 'Cliente de Teste',
            'customer_passwd' => Hash::make('mlr1234seew'),
        ]);

        // Arrange: Retorna um produto pelo SKU
        $catalogProduct = CatalogProductsRepository::getProductBySku('ATSASSCC8RB90B');

        // Arrange: Retorna a entidade do review
        $reviewEntity = ReviewEntityRepository::getEntity('product');

        // Arrange
        $data = [
            'entity_id' => $reviewEntity->entity_id, // product
            'entity_pk_value' => $catalogProduct->product_id, // Scoter Elétrica
            'customer_id' => $customer->customer_id,
            'store_id' => 1,
            'status_id' => ReviewStatus::APPROVED,
            'nickname' => 'Gatto',
            'title' => 'Esse Patinete é Ótimo',
            'detail' => 'O Patinete é muito Elogiado pela sua exelente qualidade',
            'rating' => 5, // Nota de 1 a 5
            'likes_count' => 0
        ];

        // Act: Cria o Review
        $review = app(ReviewService::class)->createReview($data);

        $this->assertInstanceOf(
            Review::class,
            $review
        );

        // Assert: o Review foi realmente persistido
        $this->assertModelExists($review);

        // Assert: pertence ao customer informado
        $this->assertSame(
            $customer->customer_id,
            $review->customer_id
        );

        // Assert: pertence ao produto informado
        $this->assertSame(
            $catalogProduct->product_id,
            $review->entity_pk_value
        );

        // Assert: mantém os dados principais enviados
        $this->assertSame('Gatto', $review->nickname);
        $this->assertSame('Esse Patinete é Ótimo', $review->title);
        $this->assertSame(5, $review->rating);

    }

    public function testGetReviewsFrom()
    {

        // Arrange: Retorna a entidade "product"
        $reviewEntity = ReviewEntityRepository::getEntity('product');

        // Arrange: Retorna um produto pelo SKU
        $catalogProduct = CatalogProductsRepository::getProductBySku('ATSASSCC8RB90B');

        // Act: Retorna o review
        $reviews = app(ReviewService::class)->getReviewsFrom(
            reviewEntity: $reviewEntity,
            entityIdValue: $catalogProduct->product_id,
            perPage: 1
        );

        $this->assertInstanceOf(
            LengthAwarePaginator::class,
            $reviews
        );

        $this->assertCount(
            1,
            $reviews
        );


    }

}
