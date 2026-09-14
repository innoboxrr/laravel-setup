/**
 * El menú del administrador, construido a partir de las rutas del módulo de
 * LaraPack: un modelo que se genere después aparece solo al compilar.
 */

const DEFAULT_ICON = 'box'

export function readTitle(record) {
    const title = record?.meta?.title

    return typeof title === 'function' ? title() : title
}

/**
 * Una entrada es una ruta de primer nivel, con nombre y título y sin
 * parámetros: `user/:id` necesita un registro y no se abre desde un menú.
 */
export function isMenuRoute(record) {
    return Boolean(record
        && typeof record.name === 'string'
        && typeof record.path === 'string'
        && ! record.path.includes(':')
        && readTitle(record))
}

const entryFor = (record) => ({
    id: record.name,
    label: readTitle(record),
    icon: record.meta?.icon ?? DEFAULT_ICON,
    to: { name: record.name },
})

/**
 * @returns {Array<{ id: string, label: string|null, items: Array<object> }>}
 */
export function buildMenu(moduleRoutes = [], { isAdmin = false, adminOnly = [], t = (key) => key } = {}) {
    const candidates = (Array.isArray(moduleRoutes) ? moduleRoutes : []).filter(isMenuRoute)

    const main = [
        { id: 'admin.dashboard', label: t('Home'), icon: 'home', to: { name: 'admin.dashboard' } },
        ...candidates.filter((record) => ! adminOnly.includes(record.name)).map(entryFor),
    ]

    const groups = [{ id: 'main', label: null, items: main }]

    if (isAdmin) {
        groups.push({
            id: 'administration',
            label: t('Administration'),
            items: [
                ...candidates.filter((record) => adminOnly.includes(record.name)).map(entryFor),
                { id: 'admin.site', label: t('Site'), icon: 'mdi:web', to: { name: 'admin.site' } },
                { id: 'log-viewer', label: t('Logs'), icon: 'mdi:text-box-search-outline', href: '/log-viewer', external: true },
                { id: 'env-editor', label: t('Environment'), icon: 'mdi:tune-variant', href: '/env-editor', external: true },
            ],
        })
    }

    return groups
}

/**
 * Las entradas en una sola lista, sin el inicio: las tarjetas del dashboard.
 */
export function menuShortcuts(groups) {
    return groups.flatMap((group) => group.items).filter((item) => item.id !== 'admin.dashboard')
}
