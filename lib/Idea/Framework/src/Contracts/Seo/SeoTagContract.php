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
namespace Idea\Framework\Contracts\Seo;

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
