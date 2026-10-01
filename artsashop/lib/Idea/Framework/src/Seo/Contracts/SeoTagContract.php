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
namespace Idea\Framework\Seo\Contracts;

use Idea\Framework\Seo\Data\SeoPageData;

interface SeoTagContract
{
    /**
     * Inicializa a tag com os dados da página.
     */
    public function initialize(SeoPageData $data): void;

    /**
     * Retorna o HTML final da tag.
     */
    public function render(): string;

    /**
     * Define se a tag deve ser renderizada.
     */
    public function shouldRender(): bool;
}
