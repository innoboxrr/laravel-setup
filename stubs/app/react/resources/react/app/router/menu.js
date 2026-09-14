import t from 'innoboxrr-i18n'

import { adminBase, adminOnly as defaultAdminOnly, adminTools } from '../config.js'
import { hasParams } from './guards.js'

const joinPath = (base, path) => `${base.replace(/\/+$/, '')}/${String(path).replace(/^\/+/, '')}`

/**
 * El menú del administrador, construido desde las rutas del módulo: un modelo
 * que se genere después aparece solo al compilar.
 *
 * Entra cada ruta de primer nivel con título y sin parámetros, en el orden en
 * que la exporta el módulo. Las de `adminOnly` van al grupo «Administración»,
 * que sólo existe para quien administra.
 *
 * @param {{ moduleRoutes?: Array<Record<string, any>>, isAdmin?: boolean, adminOnly?: string[], base?: string, tools?: Array<Record<string, string>>, translate?: (key: string) => string }} options
 * @returns {{ main: Array<Record<string, any>>, admin: Array<Record<string, any>> }}
 */
export function buildMenu({
    moduleRoutes = [],
    isAdmin = false,
    adminOnly = defaultAdminOnly,
    base = adminBase,
    tools = adminTools,
    translate = t,
} = {}) {
    const entries = moduleRoutes
        .filter((route) => route && ! route.index && route.path && ! hasParams(route.path) && route.handle?.title)
        .map((route) => ({
            id: route.id ?? route.path,
            label: String(route.handle.title),
            to: joinPath(base, route.path),
            icon: route.handle.icon ?? 'box',
            restricted: Boolean(route.id && adminOnly.includes(route.id)),
        }))

    const main = [
        { id: 'admin.dashboard', label: translate('Home'), to: base, icon: 'home', end: true },
        ...entries.filter((entry) => ! entry.restricted),
    ]

    if (! isAdmin) {
        return { main, admin: [] }
    }

    const admin = [
        ...entries.filter((entry) => entry.restricted),
        { id: 'admin.site', label: translate('Site'), to: joinPath(base, 'site'), icon: 'mdi:web' },
        ...tools.map((tool) => ({ id: tool.id, label: translate(tool.label), href: tool.href, icon: tool.icon, external: true })),
    ]

    return { main, admin }
}
