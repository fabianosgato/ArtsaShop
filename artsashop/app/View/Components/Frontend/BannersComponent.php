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
namespace App\View\Components\Frontend;

use Closure;
use Idea\Framework\Repository\Cms\CmsBannerRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class BannersComponent extends Component
{

    public $banners = [];

    /**
     * Create a new component instance.
     */
    public function __construct($bannerLocal = 'banner_main_top')
    {

        $this->banners = [];

        $request = request()->route()->getName();

        if ($request === 'index.home') {

            $cacheKey = "banners_home_{$bannerLocal}";

            $this->banners = Cache::rememberForever($cacheKey, function () use ($bannerLocal) {

                return CmsBannerRepository::getData()
                    ->where('is_active', 1)
                    ->where('banner_type', 'banner_home')
                    ->where('banner_local', $bannerLocal)
                    ->orderBy('banner_order')
                    ->get();

            });

        }

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('frontend.components.html.banners-component');
    }

}
