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
namespace Modules\Review\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Idea\Framework\Concerns\ResultApiResponse;
use Idea\Framework\Repository\Reviews\ReviewEntityRepository;
use Illuminate\Http\Request;
use Modules\Review\Http\Requests\ReviewListRequest;
use Modules\Review\Services\ReviewService;

class ReviewController extends Controller
{

    use ResultApiResponse;

    /**
     * Lista os reviews
     */
    public function index(ReviewListRequest $request)
    {

        // Retorna os valores específicos para maior segurança
        $queryParams = $request->only(['entity', 'entityIdValue', 'perPage']);

        // Valida se a entidade está vindo corretamente
        $reviewEntity = ReviewEntityRepository::getEntity(
            entity: $queryParams['entity']
        );

        if ($reviewEntity) {

            // Retorna as reviews de uma entidade
            $reviews = app(ReviewService::class)->getReviewsFrom(
                reviewEntity: $reviewEntity,
                entityIdValue: $request->input('entityIdValue'),
                perPage:$request->input('perPage')
            );

            if ($reviews) {
                return response()->json(
                    $this->paginatedResponse($reviews)
                );

            } else {
                return response()->json(
                    $this->response([])
                );

            }

        } else {
            return response()->json(
                $this->error('Entidade de Review não econtrada')
            );

        }




        return response()->json([]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        return response()->json([]);
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        //

        return response()->json([]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //

        return response()->json([]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //

        return response()->json([]);
    }
}
