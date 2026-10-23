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
namespace Modules\Review\Services;

use App\Models\ReviewEntity;
use Idea\Framework\Repository\Reviews\ReviewRepository;
use Idea\Framework\Services\AbstractService;

class ReviewService extends AbstractService
{

    public function createReview($data)
    {
        return ReviewRepository::create(
            attributes:[
                'entity_id' => $data['entity_id'], // product
                'entity_pk_value' => $data['entity_pk_value'], // Scoter Elétrica
                'customer_id' => $data['customer_id'],
                'store_id' => $data['store_id'],
            ],
            values:[
                'status_id' => $data['status_id'],
                'nickname' => $data['nickname'],
                'title' => $data['title'],
                'detail' => $data['detail'],
                'rating' => $data['rating'],
                'likes_count'=> $data['likes_count']
            ]
        );
    }

    public function getReviewsFrom(
        ReviewEntity $reviewEntity,
        int $entityIdValue,
        int $perPage = 20): \Illuminate\Pagination\LengthAwarePaginator
    {

        return ReviewRepository::getReviewsFromEntity(
            $reviewEntity,
            $entityIdValue,
            $perPage
        );

    }

}
