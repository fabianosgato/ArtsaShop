import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import {bunny} from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';
import collectModuleAssetsPaths from './vite-module-loader.js';


export default defineConfig({
    devtools: {
        apply: 'serve',
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            fonts: [
                bunny('Instrument Sans', {
                    weights: [400, 500, 600],
                }),
            ],
        }),
        vue(),
        tailwindcss(),
        collectModuleAssetsPaths()
    ],
    resolve: {
        alias: {
            'ziggy-js': '/vendor/tightenco/ziggy/src/js',
        },
    },
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
