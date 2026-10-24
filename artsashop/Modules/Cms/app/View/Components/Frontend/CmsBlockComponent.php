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
namespace Modules\Cms\View\Components\Frontend;

use Idea\Framework\Repository\Cms\CmsBlockRepository;
use Illuminate\View\Component;
use Illuminate\View\View;

class CmsBlockComponent extends Component
{

    public $blockContent;

    /**
     * Create a new component instance.
     */
    public function __construct(string $indentifier)
    {
        $this->blockContent = CmsBlockRepository::getData()
            ->where(['identifier' => $indentifier])
            ->get()
            ->first();
    }

    /**
     * Get the view/contents that represent the component.
     */
    public function render(): View|string
    {
        return view('cms::frontend.components.cms-block-component');
    }
}
