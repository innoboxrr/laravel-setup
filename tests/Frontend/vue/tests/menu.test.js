import { describe, expect, it } from 'vitest'
import { buildMenu, isMenuRoute, menuShortcuts } from '@app/router/menu.js'

// La forma de las rutas que exporta un módulo de LaraPack: títulos como getter,
// hijas con parámetros y alguna ruta que no debe salir en el menú.
const moduleRoutes = [
    {
        path: 'user',
        name: 'AdminUsers',
        meta: { get title() { return 'Users' }, auth: true },
        children: [{ path: ':id', name: 'AdminShowUser', meta: { title: 'User', auth: true } }],
    },
    { path: 'product', name: 'AdminProducts', meta: { get title() { return 'Products' }, auth: true } },
    { path: ':id/preview', name: 'AdminPreview', meta: { title: 'Preview', auth: true } },
    { path: 'hidden', name: 'AdminHidden', meta: { auth: true } },
    { path: 'category', name: 'AdminCategories', meta: { title: () => 'Categories', icon: 'mdi:tag', auth: true } },
]

const t = (key) => `«${key}»`

const ids = (items) => items.map((item) => item.id)

describe('buildMenu', () => {
    it('builds the entries from the module routes, dashboard first and in module order', () => {
        const [main, ...rest] = buildMenu(moduleRoutes, { isAdmin: false, adminOnly: ['AdminUsers'], t })

        expect(rest).toEqual([])
        expect(ids(main.items)).toEqual(['admin.dashboard', 'AdminProducts', 'AdminCategories'])
        expect(main.items[0]).toEqual({ id: 'admin.dashboard', label: '«Home»', icon: 'home', to: { name: 'admin.dashboard' } })
        expect(main.items[1]).toEqual({ id: 'AdminProducts', label: 'Products', icon: 'box', to: { name: 'AdminProducts' } })
        expect(main.items[2].label).toBe('Categories')
        expect(main.items[2].icon).toBe('mdi:tag')
    })

    it('hides adminOnly routes and the administration group from someone who does not administer', () => {
        const groups = buildMenu(moduleRoutes, { isAdmin: false, adminOnly: ['AdminUsers'], t })
        const all = groups.flatMap((group) => ids(group.items))

        expect(all).not.toContain('AdminUsers')
        expect(all).not.toContain('admin.site')
        expect(all).not.toContain('log-viewer')
    })

    it('gives an administrator the administration group in its order', () => {
        const groups = buildMenu(moduleRoutes, { isAdmin: true, adminOnly: ['AdminUsers'], t })

        expect(ids(groups)).toEqual(['main', 'administration'])
        expect(ids(groups[0].items)).toEqual(['admin.dashboard', 'AdminProducts', 'AdminCategories'])
        expect(groups[1].label).toBe('«Administration»')
        expect(ids(groups[1].items)).toEqual(['AdminUsers', 'admin.site', 'log-viewer', 'env-editor'])
        expect(groups[1].items[2]).toMatchObject({ href: '/log-viewer', external: true, label: '«Logs»' })
        expect(groups[1].items[3]).toMatchObject({ href: '/env-editor', external: true, label: '«Environment»' })
    })

    it('adds a model generated later without touching the menu', () => {
        const later = [...moduleRoutes, { path: 'invoice', name: 'AdminInvoices', meta: { title: 'Invoices', auth: true } }]

        expect(ids(buildMenu(later, { t })[0].items)).toEqual(['admin.dashboard', 'AdminUsers', 'AdminProducts', 'AdminCategories', 'AdminInvoices'])
    })

    it('rejects routes without a name, without a title or with parameters', () => {
        expect(isMenuRoute({ path: 'x', meta: { title: 'X' } })).toBe(false)
        expect(isMenuRoute({ path: 'x', name: 'X', meta: {} })).toBe(false)
        expect(isMenuRoute({ path: 'x/:id', name: 'X', meta: { title: 'X' } })).toBe(false)
        expect(isMenuRoute({ path: 'x', name: 'X', meta: { title: 'X' } })).toBe(true)
        expect(buildMenu(undefined, { t })[0].items).toHaveLength(1)
    })

    it('lists the dashboard cards without the dashboard itself', () => {
        const groups = buildMenu(moduleRoutes, { isAdmin: true, adminOnly: ['AdminUsers'], t })

        expect(ids(menuShortcuts(groups))).toEqual(['AdminProducts', 'AdminCategories', 'AdminUsers', 'admin.site', 'log-viewer', 'env-editor'])
    })
})
