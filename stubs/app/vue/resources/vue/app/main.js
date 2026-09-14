import axios from 'axios'
import { createApp } from 'vue'
import { createPinia } from 'pinia'
import { setRoutes } from 'innoboxrr-route-resolver'
import t from 'innoboxrr-i18n'
import { notify } from 'innoboxrr-form-core'
import 'innoboxrr-form-core/styles'

import routes from '../routes.json'
import App from './App.vue'
import { adminOnly } from './config.js'
import { configureAxios, installInterceptors } from './http.js'
import { setupI18n } from './i18n.js'
import { modulePlugin, moduleRoutes, moduleTranslations } from './module.js'
import { createAppRouter, documentTitle } from './router/index.js'
import { installGuards, requiresGuest } from './router/guards.js'
import { useAuthStore } from './stores/auth.js'
import { useOptionsStore } from './stores/options.js'
import { useUiStore } from './stores/ui.js'

import './styles/app.css'
import './styles/site.css'

// El aspecto del módulo de LaraPack, si ya se generó alguno.
import.meta.glob('../src/theme.js', { eager: true })

async function boot() {
    configureAxios(axios)
    setRoutes(routes)
    setupI18n(moduleTranslations)

    const pinia = createPinia()
    const app = createApp(App)

    app.use(pinia)

    if (modulePlugin?.install) {
        app.use(modulePlugin)
    }

    useUiStore(pinia).init()

    const auth = useAuthStore(pinia)
    const options = useOptionsStore(pinia)

    // Las guardas y la primera página necesitan saber quién es y qué sitio
    // pintar. Un fallo de cualquiera de las dos no impide arrancar.
    await Promise.allSettled([auth.load(), options.load()])

    const router = createAppRouter({ moduleRoutes })

    installGuards(router, {
        getSession: () => ({ authenticated: auth.authenticated, isAdmin: auth.isAdmin }),
        adminOnly,
        onDenied: () => notify({ message: t('Only an administrator can open that page.'), variant: 'warning' }),
    })

    router.afterEach((to) => {
        document.title = documentTitle(to, options.option) || document.title
    })

    installInterceptors({
        onUnauthorized: () => {
            auth.clear()

            const current = router.currentRoute.value

            if (! requiresGuest(current)) {
                router.push({ name: 'auth.login', query: { redirect: current.fullPath } })
            }
        },
    })

    app.use(router)
    app.mount('#app')
}

boot()
