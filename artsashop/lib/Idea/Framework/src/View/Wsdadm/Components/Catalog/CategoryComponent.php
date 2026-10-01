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

namespace Idea\Framework\View\Wsdadm\Components\Catalog;

use Idea\Framework\Repository\Catalog\CatalogCategoryRepository;

class CategoryComponent
{

    public function getInputCategories(int $level = 0, int $parentId = 0): array
    {

        $inputData = [];

        // Busca categorias filhas do parent atual
        $categories = CatalogCategoryRepository::getCategoriesTree(
            level: $level,
            parentId: $parentId
        );

        foreach ($categories as $category) {

            // Prefixo visual conforme o nível
            $prefix = str_repeat('-', $level);

            $inputData[] = [
                'id' => $category['entity_id'],
                'name' => $prefix . $category['category'],
            ];

            // Busca recursivamente os filhos da categoria atual
            $children = $this->getInputCategories(
                $level + 1,
                $category['entity_id']
            );

            // Mescla os filhos no array principal
            $inputData = array_merge($inputData, $children);
        }

        return $inputData;

    }


}
