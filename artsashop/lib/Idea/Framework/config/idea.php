<?php
return [
    'breadcrumbs' => [
        'files' => base_path('routes/breadcrumbs.php'),
        'manager-class' => Idea\Framework\View\Front\Breadcrumbs\BreadcrumbsManager::class,
        'generator-class' => Idea\Framework\View\Front\Breadcrumbs\Generator::class,
    ],
    'cache' => [
        'types' => [
            'seo-meta' => [
                'expire_in' => 3200
            ],
            'store_host' => [
                'expire_in' => 0
            ],
            'catalog_products' => [
                'expire_in' => 3600
            ],
            'catalog_category' => [
                'expire_in' => 3600
            ],
            'attributes_set' => [
                'expire_in' => 3600
            ],
            'cms' => [
                'expire_in' => 3600
            ],
            'homepage' => [
                'expire_in' => 3600
            ],
            'banners' => [
                'expire_in' => 0
            ],
        ]
    ]
];
