import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { fileURLToPath, URL } from 'node:url'
import { url } from 'node:inspector';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // 'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        vue({}),
    ],
    resolve:{
        alias:{
            '@shared': fileURLToPath(new URL('./resources/js/Shared',import.meta.url)),
            '@fontawesome': fileURLToPath(new URL('./node_modules/@fortawesome/fontawesome-free',import.meta.url)),
            '~bootstrap':fileURLToPath(new URL('./node_modules/bootstrap',import.meta.url))
        }
    }
});
