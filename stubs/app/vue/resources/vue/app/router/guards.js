/**
 * Las guardas del router, como funciones puras: reciben la ruta de destino y
 * la sesión y dicen a dónde ir.
 *
 * Miran toda la cadena de rutas (`to.matched`) y no sólo la última: una ruta
 * hija del administrador hereda el `auth` de /admin, y el detalle de un usuario
 * hereda que su listado esté en `adminOnly`.
 */

const records = (to) => (Array.isArray(to?.matched) ? to.matched : [])

export function requiresGuest(to) {
    return records(to).some((record) => record.meta?.guest === true)
}

export function requiresAuth(to) {
    return records(to).some((record) => record.meta?.auth === true)
}

export function requiresAdmin(to, adminOnly = []) {
    return records(to).some((record) => record.meta?.admin === true
        || (typeof record.name === 'string' && adminOnly.includes(record.name)))
}

/**
 * Sólo una ruta de esta aplicación: `//otro.sitio` o `https://…` en
 * `?redirect=` convertirían el acceso en una redirección abierta.
 */
export function safeRedirect(value) {
    if (typeof value !== 'string' || ! value.startsWith('/')) {
        return null
    }

    if (value.startsWith('//') || value.startsWith('/\\')) {
        return null
    }

    return value
}

/**
 * @returns {{ redirect: object|null, reason: 'guest'|'auth'|'admin'|null }}
 */
export function resolveNavigation(to, { authenticated = false, isAdmin = false, adminOnly = [] } = {}) {
    if (requiresGuest(to) && authenticated) {
        return { redirect: { name: 'admin.dashboard' }, reason: 'guest' }
    }

    const needsAdmin = requiresAdmin(to, adminOnly)

    if ((requiresAuth(to) || needsAdmin) && ! authenticated) {
        return { redirect: { name: 'auth.login', query: { redirect: to.fullPath } }, reason: 'auth' }
    }

    if (needsAdmin && ! isAdmin) {
        return { redirect: { name: 'admin.dashboard' }, reason: 'admin' }
    }

    return { redirect: null, reason: null }
}

export function installGuards(router, { getSession, adminOnly = [], onDenied = () => {} }) {
    return router.beforeEach((to) => {
        const { authenticated, isAdmin } = getSession()
        const { redirect, reason } = resolveNavigation(to, { authenticated, isAdmin, adminOnly })

        if (reason === 'admin') {
            onDenied(reason, to)
        }

        return redirect ?? true
    })
}
