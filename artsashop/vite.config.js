import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import {bunny} from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // Arquivos do backend (wsdadm)
                'resources/css/wsdadm/app.css',
                'resources/js/wsdadm/app.js',

                // Arquivos do Frontend
                'resources/css/frontend/app.css',
                'resources/js/frontend/app.js'
            ],
            refresh: true,
            fonts: [
                bunny('Instrument Sans', {
                    weights: [400, 500, 600],
                }),
            ],
        }),
        tailwindcss(),
    ],
    // 🔥 ADICIONE ESTE BLOCO ABAIXO: Libera o Tailwind v4 para ler o Filament no vendor
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
    },
});

