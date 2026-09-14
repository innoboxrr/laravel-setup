import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import react from '@vitejs/plugin-react'
import path from 'node:path'

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/react/app/main.jsx',
            refresh: true,
        }),
        react(),
    ],

    resolve: {
        alias: {
            '@app': path.resolve(import.meta.dirname, 'resources/react/app'),
        },
        // Una sola copia de cada una. Con dos copias de axios los interceptores
        // de la aplicación no verían las peticiones del módulo de LaraPack, y
        // con dos de React o del router sus hooks fallan.
        dedupe: ['react', 'react-dom', 'react-router-dom', 'zustand', 'axios'],
    },

    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
})
