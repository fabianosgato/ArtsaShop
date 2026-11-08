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
