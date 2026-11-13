import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import {bunny} from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';
import inertia from '@inertiajs/vite';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/wsdadm/app.css',
                'resources/js/wsdadm/app.js',
                'resources/css/frontend/app.css',
                'resources/js/frontend/app.ts',
            ],
            refresh: true,
            fonts: [
                bunny('Instrument Sans', {
                    weights: [400, 500, 600],
                }),
            ],
        }),
        tailwindcss({
            // Escanear arquivos Vue/TS para detectar classes Tailwind
            sourceFiles: [
                './resources/js/frontend/**/*.vue',
                './resources/js/frontend/**/*.ts',
                './resources/views/**/*.blade.php',
            ],
        }),
        vue({
            template: {
                compilerOptions: {
                    isCustomElement: (tag) => tag.startsWith('livewire:'),
                },
            },
        }),
        inertia({
            // 🔥 SSR TEMPORARIAMENTE DESABILITADO PARA DEV
            // REATIVAR EM PRODUÇÃO: ssr: 'resources/js/frontend/ssr.ts',
            resolve: ['resources/js/frontend/pages/**/*.vue'],
        }),
    ],

    resolve: {
        alias: {
            '@': path.resolve(import.meta.dirname, 'resources/js/frontend'),
            '@components': path.resolve(import.meta.dirname, 'resources/js/frontend/components'),
            '@pages': path.resolve(import.meta.dirname, 'resources/js/frontend/pages'),
            '@layouts': path.resolve(import.meta.dirname, 'resources/js/frontend/layouts'),
            '@composables': path.resolve(import.meta.dirname, 'resources/js/frontend/composables'),
            '@stores': path.resolve(import.meta.dirname, 'resources/js/frontend/stores'),
            '@plugins': path.resolve(import.meta.dirname, 'resources/js/frontend/plugins'),
            '@utils': path.resolve(import.meta.dirname, 'resources/js/frontend/utils'),
            /* Módulos */
            '@brands': path.resolve(import.meta.dirname, 'Modules/Brands/resources/js/frontend'),
            '@catalog': path.resolve(import.meta.dirname, 'Modules/Catalog/resources/js/frontend'),
            '@catalogsearch': path.resolve(import.meta.dirname, 'Modules/CatalogSearch/resources/js/frontend'),
            '@checkout': path.resolve(import.meta.dirname, 'Modules/Checkout/resources/js/frontend'),
            '@cms': path.resolve(import.meta.dirname, 'Modules/Cms/resources/js/frontend'),
            '@customers': path.resolve(import.meta.dirname, 'Modules/Customers/resources/js/frontend'),
            '@payments': path.resolve(import.meta.dirname, 'Modules/Payments/resources/js/frontend'),
            '@review': path.resolve(import.meta.dirname, 'Modules/Review/resources/js/frontend'),
            '@sales': path.resolve(import.meta.dirname, 'Modules/Sales/resources/js/frontend'),
            '@salesRules': path.resolve(import.meta.dirname, 'Modules/SalesRules/resources/js/frontend')
        },
    },

    ssr: {
        external: ['vue', '@inertiajs/vue3', 'pinia', 'ziggy-js'],
        target: 'node',
        noExternal: ['@inertiajs/vue3'],
    },

    server: {
        fs: {
            allow: [
                'resources',
                'vendor/filament',
            ],
        },
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
        hmr: {
            port: 5173,
        },
    },

    build: {
        sourcemap: false,
        chunkSizeWarningLimit: 1000,
        rollupOptions: {
            output: {
                manualChunks: (id) => {
                    if (id.includes('node_modules')) {
                        if (id.includes('vue') || id.includes('@inertiajs/vue3') || id.includes('vue-router')) {
                            return 'vendor-vue';
                        }
                        if (id.includes('pinia') || id.includes('swiper') || id.includes('@fortawesome/fontawesome-free')) {
                            return 'vendor-ui';
                        }
                        if (id.includes('ziggy-js') || id.includes('daisyui')) {
                            return 'vendor-utils';
                        }
                        return 'vendor';
                    }
                },
            },
        },
    },

    css: {
        devSourcemap: true,
    },
});
