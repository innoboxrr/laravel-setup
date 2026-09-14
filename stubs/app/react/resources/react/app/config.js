/**
 * Lo que decide la aplicación y el módulo de LaraPack no sabe.
 */

/**
 * Los ids de las rutas del módulo que sólo ve quien administra. Un id cubre
 * también a sus hijas: sin eso el detalle de un usuario quedaría abierto
 * aunque el listado no.
 */
export const adminOnly = ['AdminUsers']

/** Donde se montan las rutas del módulo; es también el prefijo de sus nombres. */
export const adminBase = '/admin'

/** El update del usuario que genera LaraPack desde laraimport.json. */
export const userUpdateRoute = 'api.app.user.update'

/**
 * Las herramientas del grupo «Administración» que no son pantallas de la SPA:
 * las sirve Laravel, por eso se abren en otra pestaña.
 */
export const adminTools = [
    { id: 'log-viewer', label: 'Logs', href: '/log-viewer', icon: 'mdi:text-box-search-outline' },
    { id: 'env-editor', label: 'Environment', href: '/env-editor', icon: 'mdi:tune-variant' },
]

/** Cada cuánto se pregunta por las notificaciones sin leer. */
export const notificationsInterval = 60_000

/** Las páginas del sitio: su clave en la opción `theme`, su ruta y su nombre. */
export const sitePages = [
    { key: 'home', path: '/', name: 'site.home', label: 'Home' },
    { key: 'privacy', path: '/privacy', name: 'site.privacy', label: 'Privacy' },
    { key: 'terms', path: '/terms', name: 'site.terms', label: 'Terms' },
    { key: 'contact', path: '/contact', name: 'site.contact', label: 'Contact' },
    { key: 'join', path: '/join', name: 'site.join', label: 'Join' },
]
