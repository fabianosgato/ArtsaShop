<?php
return [
    'breadcrumbs' => [
        'files' => base_path('routes/breadcrumbs.php'),
        'manager-class' => Idea\Framework\View\Front\Breadcrumbs\BreadcrumbsManager::class,
        'generator-class' => Idea\Framework\View\Front\Breadcrumbs\Generator::class,
    ],
    'images' => [
        'allowed_type_mimes' => [
            'image/jpeg',
            'image/png',
            'image/webp',
            'image/gif',
        ],
        'images_sizes' => [
            'product_main'      => [1000, 1000],    // Imagem padrão do produto
            'product_page'      => [383, 383],      // Imagem na página do produto
            'product_sharing'   => [300, 300],      // Imagem de compartilhamento (WhatsApp)
            'product_listing'   => [215, 215],      // Listagem do produtos
            'product_thumbnail' => [80, 80],        // Thubnails do produto
        ]
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
