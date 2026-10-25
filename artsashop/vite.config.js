import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import {bunny} from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';
import path from 'path';
import collectModuleAssetsPaths from './vite-module-loader.js';

async function getConfig() {
    const paths = [
        'resources/css/app.css',
        'resources/js/app.js',
    ];

    // 'Modules' = nome da pasta dos módulos (confira o seu, é case-sensitive no Linux)
    const allPaths = await collectModuleAssetsPaths(paths, 'Modules');

    return defineConfig({
        devtools: {
            apply: 'serve'
        },
        plugins: [
            laravel({
                input: allPaths,
                refresh: true,
                fonts: [
                    bunny('Instrument Sans', { weights: [400, 500, 600] }),
                ],
            }),
            vue(),
            tailwindcss(),
        ],
        resolve: {
            alias: {
                'ziggy-js': path.resolve(import.meta.dirname, 'vendor/tightenco/ziggy/dist/index.esm.js'),
            },
        },
        server: {
            watch: {
                ignored: ['**/storage/framework/views/**'],
            },
        },
    });
}

export default getConfig();
