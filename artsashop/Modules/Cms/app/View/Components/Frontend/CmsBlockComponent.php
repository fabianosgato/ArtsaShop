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
