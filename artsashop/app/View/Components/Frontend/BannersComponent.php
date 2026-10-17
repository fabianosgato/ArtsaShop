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
namespace App\View\Components\Frontend;

use Closure;
use Idea\Framework\Repository\Cms\CmsBannerRepository;
use Idea\Framework\Services\ServiceCache;
use Illuminate\Contracts\View\View;
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

            $this->banners = app(ServiceCache::class)->remember(
                cacheKey: "banners_home_{$bannerLocal}",
                tags:['banners'],
                closure: function () use ($bannerLocal) {
                    return CmsBannerRepository::getData()
                        ->where('is_active', 1)
                        ->where('banner_type', 'banner_home')
                        ->where('banner_local', $bannerLocal)
                        ->orderBy('banner_order')
                        ->get();
                }
            );

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
