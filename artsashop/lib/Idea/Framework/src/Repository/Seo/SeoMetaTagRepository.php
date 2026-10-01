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

namespace Idea\Framework\Repository\Seo;

use App\Models\SeoMetaTag;
use Idea\Framework\Repository\AbstractRepository;
use Illuminate\Support\Collection;

class SeoMetaTagRepository extends AbstractRepository
{

    protected static $model = SeoMetaTag::class;

    /**
     * Retorna todas as meta tags ativas visíveis para páginas
     */
    public function getActiveForPage(): Collection
    {
        return SeoMetaTagRepository::getData()
            ->where('status', '=','active')
            ->whereIn('visibility', ['page', 'global'])
            ->orderBy('group')
            ->orderBy('ordernation')
            ->get();
    }

    /**
     * Retorna meta tags agrupadas
     */
    public function getGroupedForPage(): Collection
    {
        return $this->getActiveForPage()
            ->groupBy(fn($tag) => $tag->group ?: 'default');
    }

}
