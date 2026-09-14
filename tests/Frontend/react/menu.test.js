import { describe, expect, it } from 'vitest'

import { buildMenu } from '@app/router/menu.js'

const translate = (key) => key

const moduleRoutes = [
    { path: 'posts', id: 'AdminPosts', handle: { title: 'Posts', auth: true }, children: [{ path: ':id', id: 'AdminShowPost', handle: { title: 'Post' } }] },
    { path: 'user', id: 'AdminUsers', handle: { title: 'Users', auth: true } },
    // Con parámetros no puede ser una entrada: no hay a dónde enlazar.
    { path: 'report/:year', id: 'AdminReport', handle: { title: 'Report', auth: true } },
    // Sin título tampoco.
    { path: 'hidden', id: 'AdminHidden', handle: { auth: true } },
    { path: 'categories', id: 'AdminCategories', handle: { title: 'Categories', auth: true, icon: 'mdi:shape' } },
]

const ids = (entries) => entries.map((entry) => entry.id)

describe('buildMenu', () => {
    it('puts Home first and lists titled first-level routes without params, in module order', () => {
        const { main } = buildMenu({ moduleRoutes, isAdmin: false, adminOnly: ['AdminUsers'], translate })

        expect(ids(main)).toEqual(['admin.dashboard', 'AdminPosts', 'AdminCategories'])
        expect(main[0]).toMatchObject({ label: 'Home', to: '/admin', end: true })
        expect(main[1]).toMatchObject({ label: 'Posts', to: '/admin/posts', icon: 'box' })
        expect(main[2]).toMatchObject({ to: '/admin/categories', icon: 'mdi:shape' })
    })

    it('hides the adminOnly routes and the Administration group from non-admins', () => {
        const { main, admin } = buildMenu({ moduleRoutes, isAdmin: false, adminOnly: ['AdminUsers'], translate })

        expect(ids(main)).not.toContain('AdminUsers')
        expect(admin).toEqual([])
    })

    it('gives admins the Administration group: adminOnly routes, Site, Logs and Environment', () => {
        const { main, admin } = buildMenu({ moduleRoutes, isAdmin: true, adminOnly: ['AdminUsers'], translate })

        expect(ids(main)).toEqual(['admin.dashboard', 'AdminPosts', 'AdminCategories'])
        expect(ids(admin)).toEqual(['AdminUsers', 'admin.site', 'log-viewer', 'env-editor'])

        expect(admin[0]).toMatchObject({ label: 'Users', to: '/admin/user' })
        expect(admin[1]).toMatchObject({ label: 'Site', to: '/admin/site' })
        expect(admin[2]).toMatchObject({ label: 'Logs', href: '/log-viewer', external: true })
        expect(admin[3]).toMatchObject({ label: 'Environment', href: '/env-editor', external: true })
    })

    it('reads the title getter when the menu is built', () => {
        let locale = 'en'
        const routes = [{ path: 'user', id: 'AdminUsers', handle: { get title() { return locale === 'es' ? 'Usuarios' : 'Users' } } }]

        expect(buildMenu({ moduleRoutes: routes, adminOnly: [], translate }).main[1].label).toBe('Users')

        locale = 'es'

        expect(buildMenu({ moduleRoutes: routes, adminOnly: [], translate }).main[1].label).toBe('Usuarios')
    })
})
