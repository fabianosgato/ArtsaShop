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

use App\Models\Review;
use Database\Factories\CustomerFactory;
use Idea\Framework\Repository\Catalog\CatalogProductsRepository;
use Idea\Framework\Repository\Reviews\ReviewEntityRepository;
use Illuminate\Support\Facades\Hash;
use Modules\Review\Enums\ReviewStatus;
use Modules\Review\Services\ReviewService;
use Tests\TestCase;

class ReviewServiceTest extends TestCase
{

    public function testCreateReview()
    {

        // Arrange: cria um cliente real no banco de testes.
        $user = CustomerFactory::factory()->create([
            'name' => 'Usuário de Teste',
            'status' => true,
            'password' => Hash::make('mlr1234seew'),
        ]);

        dd($user);

        // Arrange: Retorna um produto pelo SKU
        $catalogProduct = CatalogProductsRepository::getProductBySku('ATSASSCC8RB90B');

        // Arrange: Retorna a entidade do review
        $reviewEntity = ReviewEntityRepository::getEntity('product');

        // Arrange: Retorna a entidade do review

        // Arrange
        $data = [
            'entity_id' => $reviewEntity->entity_id, // product
            'entity_pk_value' => $catalogProduct->product_id, // Scoter Elétrica
            'customer_id' => 1,
            'store_id' => 1,
            'status_id' => ReviewStatus::APPROVED,
            'nickname' => 'Gatto',
            'title' => 'Esse Patinete é Ótimo',
            'detail' => 'O Patinete é muito Elogiado pela sua exelente qualidade',
            'rating' => 5, // Nota de 1 a 5
            'likes_count'=> 0
        ];

        // Act: Cria o Review
        $review = app(ReviewService::class)->createReview($data);


        $this->assertInstanceOf(
            Review::class,
            $review
        );

    }

}
