import { fileURLToPath } from 'node:url'
import { defineConfig } from 'vitest/config'
import react from '@vitejs/plugin-react'

const app = fileURLToPath(new URL('../../../stubs/app/react/resources/react/app', import.meta.url))

export default defineConfig({
    plugins: [react()],

    resolve: {
        alias: {
            '@app': app,
        },
        // Lo que se prueba vive en stubs/, fuera de este directorio: sin
        // dedupe, sus imports buscarían estos paquetes subiendo desde stubs/ y
        // no los encontrarían (ni habría una sola copia de React).
        dedupe: [
            'react',
            'react-dom',
            'react-router-dom',
            'zustand',
            'axios',
            'innoboxrr-form-core',
            'innoboxrr-http-request',
            'innoboxrr-i18n',
            'innoboxrr-js-validator',
            'innoboxrr-react-datatable',
            'innoboxrr-react-form-elements',
            'innoboxrr-route-resolver',
        ],
    },

    test: {
        environment: 'jsdom',
        globals: true,
        setupFiles: ['./setup.js'],
        include: ['**/*.test.{js,jsx}'],
        exclude: ['node_modules/**'],
        server: {
            deps: {
                // Los paquetes innoboxrr publican JSX sin compilar.
                inline: [/innoboxrr-/],
            },
        },
    },
})
