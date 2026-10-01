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

namespace Modules\Catalog\Http\Controllers\Wsdadm;

use Idea\Framework\Admin\AdminController;
use Idea\Framework\Repository\Catalog\CatalogProductMediaRepository;
use Idea\Framework\Repository\Catalog\CatalogProductsRepository;
use Idea\Framework\Repository\Eav\EavAttributeSetRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductController extends AdminController
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('wsdadm.partials.grids', [
            'componentName' => 'catalog::products.grids.catalog-product-grid'
        ]);
    }

    /**
     * Action que mostra as informações do produto
     * @param $id
     * @return \Closure|\Illuminate\Container\Container|mixed|object|null
     */
    public function show($id)
    {

        // Retorna as informacoes do produto
        $catalogProduct = CatalogProductsRepository::getProductById($id);

        return view('catalog::wsdadm.products.show', [
            'catalogProduct' => $catalogProduct,
        ]);

    }

    /**
     * Metodo Action usado para edicao do produto
     */
    public function edit($id)
    {

        // Retorna as informacoes do produto
        $catalogProduct = CatalogProductsRepository::getProductById($id);

        if ($catalogProduct) {

            // Retorna a View
            return view('wsdadm.partials.forms', [
                'componentName' => 'catalog::products.form.catalog-product-form',
                'data' => $catalogProduct->toArray()
            ]);

        } else {
            // Cria a mensagem
            Session::flash('error', "Produto inexistente com o ID {$id}!");

        }

        // Redireciona para listagem de produtos
        return redirect('/catalog/products');

    }

    /**
     * Metodo usado para edicao do produto
     * @return \Closure|\Illuminate\Container\Container|mixed|object|null
     */
    public function insert()
    {
        // Retorna a View
        return view('wsdadm.partials.forms', [
            'componentName' => 'catalog::products.form.catalog-product-form',
            'data' => [
                'attribute_set_id' => EavAttributeSetRepository::getDefaultAttributeId()
            ]
        ]);

    }

    /**
     * Metodo responsavel por atualizar a ordenação das imagens de um produto
     * @param \Illuminate\Http\Request $request
     */
    public function reorderImages(Request $request)
    {

        // Retorna a lista de imagens
        $images = $request->input('ordered_ids');

        if (count($images) > 0) {

            foreach ($images as $order => $mediaId) {

                CatalogProductMediaRepository::saveSortOrderImage(
                    mediaId: intval($mediaId),
                    sortOrder:$order
                );

            }

        }

        return response()->json([
            'success' => true,
            'media' => $images
        ]);

    }

}
