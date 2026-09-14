import { createRouter, createWebHistory } from 'vue-router'
import t from 'innoboxrr-i18n'
import SitePage from '@app/site/SitePage.vue'
import { readTitle } from './menu.js'

export const SITE_PAGES = ['home', 'privacy', 'terms', 'contact', 'join']

const sitePath = (page) => (page === 'home' ? '/' : `/${page}`)

/**
 * Las rutas del front. Los títulos son getters para que se traduzcan al leerlos
 * y no al importar este archivo.
 */
export function buildRoutes(moduleRoutes = []) {
    return [
        ...SITE_PAGES.map((page) => ({
            path: sitePath(page),
            name: `site.${page}`,
            component: SitePage,
            meta: { page },
        })),
        {
            path: '/auth',
            component: () => import('@app/auth/AuthLayout.vue'),
            meta: { guest: true },
            children: [
                { path: '', redirect: { name: 'auth.login' } },
                {
                    path: 'login',
                    name: 'auth.login',
                    component: () => import('@app/auth/LoginView.vue'),
                    meta: { get title() { return t('Sign in') } },
                },
                {
                    path: 'register',
                    name: 'auth.register',
                    component: () => import('@app/auth/RegisterView.vue'),
                    meta: { get title() { return t('Create account') } },
                },
                {
                    path: 'forgot-password',
                    name: 'auth.forgot-password',
                    component: () => import('@app/auth/ForgotPasswordView.vue'),
                    meta: { get title() { return t('Forgot your password?') } },
                },
                {
                    // Es la URL del correo de laravel-auth
                    // (`frontend.reset-password`), con el correo codificado.
                    path: 'reset-password/:token/:email',
                    name: 'auth.reset-password',
                    component: () => import('@app/auth/ResetPasswordView.vue'),
                    meta: { get title() { return t('Choose a new password') } },
                },
            ],
        },
        {
            path: '/admin',
            component: () => import('@app/admin/AdminLayout.vue'),
            meta: { auth: true },
            children: [
                {
                    path: '',
                    name: 'admin.dashboard',
                    component: () => import('@app/admin/DashboardView.vue'),
                    meta: { get title() { return t('Home') } },
                },
                {
                    path: 'profile',
                    name: 'admin.profile',
                    component: () => import('@app/admin/ProfileView.vue'),
                    meta: { get title() { return t('Profile') } },
                },
                {
                    path: 'site',
                    name: 'admin.site',
                    component: () => import('@app/admin/SiteEditorView.vue'),
                    meta: { admin: true, get title() { return t('Site') } },
                },
                ...moduleRoutes,
            ],
        },
        {
            path: '/:pathMatch(.*)*',
            name: 'not-found',
            component: () => import('@app/errors/NotFoundView.vue'),
            meta: { get title() { return t('Page not found') } },
        },
    ]
}

export function createAppRouter({ moduleRoutes = [], history = createWebHistory() } = {}) {
    return createRouter({
        history,
        routes: buildRoutes(moduleRoutes),
        scrollBehavior(to, from, savedPosition) {
            if (savedPosition) {
                return savedPosition
            }

            return to.hash ? { el: to.hash } : { top: 0 }
        },
    })
}

export function formatTitle(title, siteName) {
    const parts = [title, siteName].filter((part) => typeof part === 'string' && part.trim() !== '')

    return [...new Set(parts)].join(' · ')
}

/**
 * `<título de la página> · <site_name>`. Las páginas del sitio toman el título
 * de su JSON; el resto, el de la ruta más profunda que lo tenga.
 */
export function documentTitle(to, option) {
    const siteName = option('site_name', '')

    if (to.meta?.page) {
        return formatTitle(option(`theme.${to.meta.page}.title`, ''), siteName)
    }

    const record = [...(to.matched ?? [])].reverse().find((item) => readTitle(item))

    return formatTitle(record ? readTitle(record) : '', siteName)
}
