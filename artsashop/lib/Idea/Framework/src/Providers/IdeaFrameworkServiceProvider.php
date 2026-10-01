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

namespace Idea\Framework\Providers;

use App\Models\SysConfigDatum;
use Idea\Framework\Admin\Components\GridsTitlesCompoments;
use Idea\Framework\Admin\Components\MenuBuilderComponent;
use Idea\Framework\View\Front\Breadcrumbs\BreadcrumbsManager;
use Idea\Framework\View\Front\Breadcrumbs\Generator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Livewire\Livewire;
use Nwidart\Modules\Facades\Module;

class IdeaFrameworkServiceProvider extends ServiceProvider
{

    /**
     * Get the services provided for deferred loading.
     * @return array
     */
    public function provides(): array
    {
        return [BreadcrumbsManager::class];
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function boot(): void
    {

        if (file_exists(__DIR__ . '/../helpers.php')) {
            require_once __DIR__ . '/../helpers.php';
        }

        // Load das Views
        $this->loadViewsFrom(
            path: dirname(__FILE__, 3) . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'views',
            namespace: 'idea-components'
        );

        // Retona as configuracoes de cada modulo do Sistema
        $this->getConfigModules();

        // Load the routes/breadcrumbs.php file
        $this->registerBreadcrumbs();

    }

    /**
     * Register any application services.
     */
    public function register(): void
    {

        // Load the default config values
        $this->mergeConfigFrom(
            path: dirname(__FILE__, 3) . DIRECTORY_SEPARATOR . 'config/idea.php',
            key: 'idea'
        );

        // Register Manager class singleton with the app container
        $this->app->singleton(
            BreadcrumbsManager::class,
            config('idea.breadcrumbs.manager-class')
        );

        // Register Generator class so it can be overridden
        $this->app->bind(
            Generator::class,
            config('idea.breadcrumbs.generator-class')
        );

        $this->registerLivewireComponents();
    }

    /**
     * Register Livewire components
     */
    protected function registerLivewireComponents(): void
    {

        // Registra o Componente dos títulos dos Grids
        $this->callAfterResolving(BladeCompiler::class, function () {
            Livewire::component('titles-component', GridsTitlesCompoments::class);
        });

        // Registra o Componente que monta o menu
        $this->callAfterResolving(BladeCompiler::class, function () {
            Livewire::component('menu-builder-component', MenuBuilderComponent::class);
        });

    }

    /**
     * Load the routes/breadcrumbs.php file (if it exists) which registers available breadcrumbs.
     *
     * This method can be overridden in a child class. It is called by the boot() method, which Laravel calls
     * automatically when bootstrapping the application.
     *
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function registerBreadcrumbs(): void
    {

        // Load the routes/breadcrumbs.php file, or other configured file(s)
        $files = config('idea.breadcrumbs.files');


        if (!$files) {
            return;
        }

        // If it is set to the default value and that file doesn't exist, skip loading it rather than causing an error
        if ($files === base_path('routes/breadcrumbs.php') && !is_file($files)) {
            return;
        }

        // Support both Breadcrumbs:: and $breadcrumbs-> syntax by making $breadcrumbs variable available
        $breadcrumbs = $this->app->make(BreadcrumbsManager::class);

        // Support both a single string filename and an array of filenames (e.g. returned by glob())
        foreach ((array)$files as $file) {
            require $file;
        }

    }


    protected function getConfigModules(): void
    {

        Cache::rememberForever('modules.sysconfig.bootstrap', function () {

            // 1. Lista módulos
            $modules = Module::allEnabled();

            // 2. Carrega todos os paths existentes no banco (evita N+1)
            $existingConfigs = SysConfigDatum::query()
                ->pluck('path')
                ->toArray();

            $existingConfigs = array_flip($existingConfigs);

            foreach ($modules as $module) {

                $moduleName = strtolower($module->getName());

                // Merge config do módulo
                $this->mergeConfigFrom(
                    module_path($module->getName(), 'config/config.php'),
                    $moduleName
                );

                $sysConfigs = config("$moduleName.sysconfig");

                if (!$sysConfigs) {
                    continue;
                }

                $insertData = [];

                foreach ($sysConfigs as $path => $sysConfig) {

                    if (!isset($existingConfigs[$path])) {

                        $insertData[] = [
                            'label' => $sysConfig['label'],
                            'path' => $path,
                            'value' => $sysConfig['value'],
                        ];
                    }
                }

                // Insert em batch (muito mais performático)
                if (!empty($insertData)) {
                    SysConfigDatum::query()->insert($insertData);
                }
            }

            return true; // obrigatório pro cache

        });

    }

}
