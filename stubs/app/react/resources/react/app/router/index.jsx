import { createBrowserRouter } from 'react-router-dom'
import t from 'innoboxrr-i18n'
import { notify } from 'innoboxrr-form-core'

import { adminOnly as defaultAdminOnly, sitePages } from '../config.js'
import { useAuthStore } from '../stores/auth.js'
import { withGuards } from './guards.js'
import RootLayout from './RootLayout.jsx'

import SitePage from '../site/SitePage.jsx'
import AuthLayout from '../auth/AuthLayout.jsx'
import LoginView from '../auth/LoginView.jsx'
import RegisterView from '../auth/RegisterView.jsx'
import ForgotPasswordView from '../auth/ForgotPasswordView.jsx'
import ResetPasswordView from '../auth/ResetPasswordView.jsx'
import AdminLayout from '../admin/AdminLayout.jsx'
import DashboardView from '../admin/DashboardView.jsx'
import NotFoundView from '../errors/NotFoundView.jsx'
import ErrorView from '../errors/ErrorView.jsx'

let noticeQueued = false

/**
 * El aviso de «sólo para administradores». El loader del padre y el de la hija
 * se evalúan a la vez al entrar en una ruta: sin esto el aviso salía dos veces.
 */
export function announceDenied(denied) {
    if (denied.reason !== 'admin' || noticeQueued) {
        return
    }

    noticeQueued = true
    setTimeout(() => {
        noticeQueued = false
    }, 0)

    notify({ message: t('That section is only for administrators.'), variant: 'warning' })
}

const lazyView = (load) => async () => ({ Component: (await load()).default })

const titled = (key, extra = {}) => ({
    ...extra,
    get title() {
        return t(key)
    },
})

/**
 * El árbol de rutas del front. Las rutas del módulo de LaraPack se montan como
 * hijas de /admin, el mismo prefijo con el que se registran sus nombres.
 *
 * @param {{ moduleRoutes?: Array<Record<string, any>>, adminOnly?: string[], getSession?: () => object, onDenied?: Function }} options
 */
export function buildRoutes({
    moduleRoutes = [],
    adminOnly = defaultAdminOnly,
    getSession = () => useAuthStore.getState(),
    onDenied = announceDenied,
} = {}) {
    const site = sitePages.map((page) => ({
        id: page.name,
        ...(page.path === '/' ? { index: true } : { path: page.path.slice(1) }),
        handle: { page: page.key },
        element: <SitePage page={page.key} />,
    }))

    return withGuards([
        {
            id: 'root',
            path: '/',
            element: <RootLayout />,
            errorElement: <ErrorView />,
            HydrateFallback: () => null,
            children: [
                ...site,
                {
                    id: 'auth',
                    path: 'auth',
                    element: <AuthLayout />,
                    handle: { guest: true },
                    children: [
                        { id: 'auth.login', path: 'login', handle: titled('Log in', { guest: true }), element: <LoginView /> },
                        { id: 'auth.register', path: 'register', handle: titled('Create an account', { guest: true }), element: <RegisterView /> },
                        { id: 'auth.forgot-password', path: 'forgot-password', handle: titled('Forgot your password?', { guest: true }), element: <ForgotPasswordView /> },
                        { id: 'auth.reset-password', path: 'reset-password/:token/:email', handle: titled('Choose a new password', { guest: true }), element: <ResetPasswordView /> },
                    ],
                },
                {
                    id: 'admin',
                    path: 'admin',
                    element: <AdminLayout moduleRoutes={moduleRoutes} />,
                    handle: { auth: true },
                    children: [
                        { id: 'admin.dashboard', index: true, handle: titled('Home', { auth: true }), element: <DashboardView /> },
                        // Perfil y editor se cargan al entrar: el editor trae CodeMirror,
                        // y el sitio público no tiene por qué descargarlo.
                        { id: 'admin.profile', path: 'profile', handle: titled('Profile', { auth: true }), lazy: lazyView(() => import('../admin/ProfileView.jsx')) },
                        { id: 'admin.site', path: 'site', handle: titled('Site', { auth: true, admin: true }), lazy: lazyView(() => import('../admin/SiteEditorView.jsx')) },
                        ...moduleRoutes,
                    ],
                },
                { id: 'not-found', path: '*', handle: titled('Page not found'), element: <NotFoundView /> },
            ],
        },
    ], { adminOnly, getSession, onDenied })
}

export function createAppRouter(options = {}) {
    return createBrowserRouter(buildRoutes(options))
}
