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

namespace Idea\Framework\Repository\Reviews;

use App\Models\Review;
use App\Models\ReviewEntity;
use Idea\Framework\Repository\AbstractRepository;
use Modules\Review\Enums\ReviewStatus;

class ReviewRepository extends AbstractRepository
{

    protected static $model = Review::class;

    public static function getReviewsFromEntity(
        ReviewEntity $reviewEntity,
        int $entityIdValue,
        int $perPage
    ): \Illuminate\Pagination\LengthAwarePaginator
    {

        $query = self::getData()
            ->where(
                column: 'entity_id',
                operator:'=',
                value: $reviewEntity->entity_id
            )->where(
                column: 'entity_pk_value',
                operator:'=',
                value: $entityIdValue
            )->where(
                column: 'status_id',
                operator:'=',
                value: ReviewStatus::APPROVED
            );

        // Mostra os produtos sem estoque por último nas listagens
        $query->orderBy(
            'created_at',
            'desc'
        );

        return $query->paginate($perPage);

    }

}
