import { redirect } from 'react-router-dom'

export const hasParams = (path) => /[:*]/.test(String(path ?? ''))

export const loginPath = (target) => `/auth/login?redirect=${encodeURIComponent(target)}`

/**
 * Sólo rutas de esta aplicación: un `?redirect=//otro-sitio` convertiría el
 * login en un redirector abierto.
 */
export function safeRedirect(value, fallback = '/admin') {
    if (typeof value !== 'string' || ! value.startsWith('/') || value.startsWith('//') || value.startsWith('/\\')) {
        return fallback
    }

    return value
}

/**
 * Lo que exige una ruta, sumado a lo que exigen sus padres.
 *
 * @param {{ id?: string, handle?: Record<string, any> }} route
 * @param {{ guest?: boolean, auth?: boolean, admin?: boolean }} inherited
 * @param {string[]} adminOnly
 */
export function requirementsFor(route, inherited = {}, adminOnly = []) {
    const handle = route?.handle ?? {}

    const admin = Boolean(inherited.admin || handle.admin === true || (route?.id && adminOnly.includes(route.id)))

    return {
        guest: Boolean(inherited.guest || handle.guest === true),
        auth: Boolean(inherited.auth || handle.auth === true || admin),
        admin,
    }
}

/**
 * @param {{ guest: boolean, auth: boolean, admin: boolean }} requirements
 * @param {{ authenticated?: boolean, is_admin?: boolean }} session
 * @param {string} target  la ruta pedida, con su query
 * @returns {{ reason: 'guest'|'auth'|'admin', redirect: string } | null}
 */
export function checkAccess(requirements, session = {}, target = '/') {
    if (requirements.guest && session.authenticated) {
        return { reason: 'guest', redirect: '/admin' }
    }

    if (requirements.auth && ! session.authenticated) {
        return { reason: 'auth', redirect: loginPath(target) }
    }

    if (requirements.admin && ! session.is_admin) {
        return { reason: 'admin', redirect: '/admin' }
    }

    return null
}

export function createGuardLoader(requirements, { getSession, onDenied } = {}, loader = null) {
    return (args) => {
        const url = new URL(args.request.url)
        const denied = checkAccess(requirements, getSession?.() ?? {}, `${url.pathname}${url.search}`)

        if (denied) {
            onDenied?.(denied)

            throw redirect(denied.redirect)
        }

        return loader ? loader(args) : null
    }
}

/**
 * Pone un loader con su guarda en cada ruta del árbol.
 *
 * Cada ruta lleva el suyo, y no sólo el padre: React Router no vuelve a
 * ejecutar el loader de un padre al navegar entre sus hijas, y la sesión puede
 * haber cambiado entretanto.
 *
 * @param {Array<Record<string, any>>} routes
 * @param {{ adminOnly?: string[], getSession: () => object, onDenied?: Function }} options
 */
export function withGuards(routes = [], options = {}, inherited = {}) {
    return routes.map((route) => {
        const requirements = requirementsFor(route, inherited, options.adminOnly ?? [])

        // Se copia la ruta y no su `handle`: el título del módulo es un getter
        // que traduce al leerse, y copiarlo lo congelaría.
        const guarded = { ...route, loader: createGuardLoader(requirements, options, route.loader ?? null) }

        if (Array.isArray(route.children)) {
            guarded.children = withGuards(route.children, options, requirements)
        }

        return guarded
    })
}
