import 'innoboxrr-form-core/styles'
import 'innoboxrr-react-form-elements/src/css/form-elements.css'

import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'
import axios from 'axios'
import { setRoutes } from 'innoboxrr-route-resolver'

import routes from '../routes.json'

import App from './App.jsx'
import { adminBase } from './config.js'
import { configureHttp, installInterceptors, unauthenticatedHandler } from './http.js'
import { setupI18n } from './i18n.js'
import { createAppRouter } from './router/index.jsx'
import { useAuthStore } from './stores/auth.js'
import { useOptionsStore } from './stores/options.js'
import { useUiStore } from './stores/ui.js'

import './styles/app.css'

// El módulo de LaraPack y su tema se cargan con glob para que una aplicación
// sin modelos generados todavía compile: un glob sin coincidencias no rompe el
// build y un import sí.
const [module = {}] = Object.values(import.meta.glob('../index.js', { eager: true }))

import.meta.glob('../src/theme.js', { eager: true })

async function boot() {
    let router = null

    configureHttp(axios)

    installInterceptors(axios, {
        onUnauthenticated: unauthenticatedHandler({
            clearSession: () => useAuthStore.getState().clear(),
            navigate: (to) => router?.navigate(to),
            currentPath: () => `${window.location.pathname}${window.location.search}`,
        }),
    })

    setRoutes(routes)
    setupI18n(module.translations)
    useUiStore.getState().initTheme()

    // Con el mismo prefijo con el que se montan sus rutas: la tabla del módulo
    // construye sus enlaces por nombre.
    module.registerModuleRoutes?.(adminBase)

    // Las guardas y el sitio leen la sesión y las opciones al evaluar la
    // primera ruta, así que tienen que estar antes de crear el router.
    await Promise.all([
        useAuthStore.getState().load(),
        useOptionsStore.getState().load(),
    ])

    router = createAppRouter({ moduleRoutes: module.routes ?? [] })

    createRoot(document.getElementById('app')).render(
        <StrictMode>
            <App router={router} />
        </StrictMode>
    )
}

boot()
