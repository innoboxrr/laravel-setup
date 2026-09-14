import { defineConfig } from 'vitest/config'
import vue from '@vitejs/plugin-vue'
import path from 'node:path'

const here = import.meta.dirname

// La aplicación que se prueba vive en los stubs, fuera de esta carpeta.
const app = path.resolve(here, '../../../stubs/app/vue/resources/vue/app')

export default defineConfig({
    plugins: [vue()],
    resolve: {
        alias: [
            { find: /^@app\//, replacement: `${app}/` },
            // form-elements entero arrastra TinyMCE, CodeMirror y vue-tel-input,
            // que no arrancan en jsdom: las pruebas usan sólo lo que se monta.
            { find: /^innoboxrr-form-elements$/, replacement: path.resolve(here, 'support/form-elements.js') },
        ],
        // Los stubs no tienen node_modules: sus imports se resuelven desde aquí,
        // con una sola copia de cada paquete.
        dedupe: [
            'axios',
            'pinia',
            'vue',
            'vue-router',
            'innoboxrr-form-core',
            'innoboxrr-form-elements',
            'innoboxrr-i18n',
            'innoboxrr-js-validator',
            'innoboxrr-route-resolver',
        ],
    },
    server: {
        fs: {
            allow: [path.resolve(here, '../../..')],
        },
    },
    test: {
        environment: 'jsdom',
        globals: true,
        include: ['tests/**/*.test.js'],
        setupFiles: ['support/setup.js'],
        server: {
            deps: {
                inline: [/innoboxrr-/],
            },
        },
    },
})
