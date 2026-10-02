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

use Idea\Framework\Repository\Cms\CmsBannerRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;
use Illuminate\View\View;

class CmsBannerComponent extends Component
{

    private string $bannerLocal;

    public $banners;

    /**
     * Create a new component instance.
     */
    public function __construct($bannerLocal, $limit = 1)
    {

        // Retorna o local do banner para identificar a view que sera usada
        $this->bannerLocal = $bannerLocal;

        // Inicializa a variavel de Banners
        $this->banners = null;

        // Retorna a rota do sistema
        $request = request()->route()->getName();

        if (($request == 'index.home') && ($bannerLocal == 'banner_main_top')) {
            $this->banners = Cache::rememberForever(
                key:"banner_home_{$bannerLocal}",
                callback: function () use ($bannerLocal, $limit) {

                    return CmsBannerRepository::getData()
                        ->where('is_active', '=', 1)
                        ->where('banner_type', '=', 'banner_home')
                        ->where('banner_local', '=', $bannerLocal)
                        ->whereNotNull(['image'])
                        ->orderBy('banner_order')
                        ->limit($limit)
                        ->get();

                });

        }

    }

    /**
     * Get the view/contents that represent the component.
     */
    public function render(): View|string
    {
        if ($this->bannerLocal == 'banner_main_top') {
            return view('cms::components.frontend/cms-banner-main-top-component');
        } else if ($this->bannerLocal == 'banner_main_upper') {
            return view('cms::components.frontend/cms-banner-main-upper-component');
        } else if ($this->bannerLocal == 'banner_main_bottom') {
            return view('cms::components.frontend/cms-banner-main-upper-component');
        } else if ($this->bannerLocal == 'banner_middle_home') {
            return view('cms::components.frontend/cms-banner-middle-home-component');
        } else if ($this->bannerLocal == 'banner_bottom_home_one') {
            return view('cms::components.frontend/cms-banner-main-upper-component');
        } else if ($this->bannerLocal == 'banner_bottom_home_two') {
            return view('cms::components.frontend/cms-banner-main-upper-component');
        } else if ($this->bannerLocal == 'banner_bottom_home_tree') {
            return view('cms::components.frontend/cms-banner-main-upper-component');
        }
    }
}
