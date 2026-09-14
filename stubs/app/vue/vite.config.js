import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import path from 'node:path'

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/vue/app/main.js',
            refresh: true,
        }),
        vue({
            template: {
                // Las imágenes del sitio llegan de las opciones, no del código:
                // que Vite no intente resolver un `src` como si fuera un import.
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            '@app': path.resolve(import.meta.dirname, 'resources/vue/app'),
        },
        // El módulo de LaraPack y la aplicación tienen que compartir una sola
        // copia de cada una: form-core guarda en su módulo los avisos y el tema,
        // y dos copias de axios no comparten interceptores ni la cabecera XSRF.
        dedupe: [
            'axios',
            'pinia',
            'vue',
            'vue-router',
            'innoboxrr-form-core',
            'innoboxrr-form-elements',
            'innoboxrr-http-request',
            'innoboxrr-i18n',
            'innoboxrr-js-validator',
            'innoboxrr-route-resolver',
            'innoboxrr-vue-datatable',
        ],
    },
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
})
