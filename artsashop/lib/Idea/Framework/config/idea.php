<?php
return [
    'breadcrumbs' => [
        /*
        |--------------------------------------------------------------------------
        | Breadcrumbs File(s)
        |--------------------------------------------------------------------------
        |
        | The file(s) where breadcrumbs are defined. e.g.
        |
        | - base_path('routes/breadcrumbs.php')
        | - glob(base_path('breadcrumbs/*.php'))
        |
        */
        'files' => base_path('routes/breadcrumbs.php'),
        // Manager
        'manager-class' => Idea\Framework\View\Front\Breadcrumbs\BreadcrumbsManager::class,
        // Generator
        'generator-class' => Idea\Framework\View\Front\Breadcrumbs\Generator::class,
    ]
];
