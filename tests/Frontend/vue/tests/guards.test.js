import { describe, expect, it, vi } from 'vitest'
import { createMemoryHistory, createRouter } from 'vue-router'
import { installGuards, requiresAdmin, resolveNavigation, safeRedirect } from '@app/router/guards.js'

const record = (name, meta = {}) => ({ name, meta })
const target = (fullPath, ...matched) => ({ fullPath, matched })

const Empty = { render: () => null }

describe('resolveNavigation', () => {
    it('sends someone with a session away from guest routes', () => {
        const to = target('/auth/login', record(undefined, { guest: true }), record('auth.login'))

        expect(resolveNavigation(to, { authenticated: true }).redirect).toEqual({ name: 'admin.dashboard' })
        expect(resolveNavigation(to, { authenticated: false }).redirect).toBeNull()
    })

    it('sends a guest to the login with the route to come back to', () => {
        const to = target('/admin/profile?tab=password', record(undefined, { auth: true }), record('admin.profile'))

        expect(resolveNavigation(to, { authenticated: false })).toEqual({
            redirect: { name: 'auth.login', query: { redirect: '/admin/profile?tab=password' } },
            reason: 'auth',
        })
        expect(resolveNavigation(to, { authenticated: true }).redirect).toBeNull()
    })

    it('requires is_admin for meta.admin', () => {
        const to = target('/admin/site', record(undefined, { auth: true }), record('admin.site', { admin: true }))

        expect(resolveNavigation(to, { authenticated: true, isAdmin: false })).toEqual({
            redirect: { name: 'admin.dashboard' },
            reason: 'admin',
        })
        expect(resolveNavigation(to, { authenticated: true, isAdmin: true }).redirect).toBeNull()
    })

    it('protects adminOnly module routes and every child of them', () => {
        const adminOnly = ['AdminUsers']
        const child = target(
            '/admin/user/5/edit',
            record(undefined, { auth: true }),
            record('AdminUsers', { auth: true }),
            record('AdminShowUser', { auth: true }),
            record('AdminEditUser', { auth: true }),
        )

        expect(requiresAdmin(child, adminOnly)).toBe(true)
        expect(resolveNavigation(child, { authenticated: true, isAdmin: false, adminOnly }).reason).toBe('admin')
        expect(resolveNavigation(child, { authenticated: true, isAdmin: true, adminOnly }).redirect).toBeNull()
        expect(resolveNavigation(child, { authenticated: false, adminOnly }).redirect.name).toBe('auth.login')

        const other = target('/admin/product', record(undefined, { auth: true }), record('AdminProducts', { auth: true }))

        expect(resolveNavigation(other, { authenticated: true, isAdmin: false, adminOnly }).redirect).toBeNull()
    })

    it('lets anybody see a public route', () => {
        expect(resolveNavigation(target('/', record('site.home', { page: 'home' }))).redirect).toBeNull()
    })
})

describe('safeRedirect', () => {
    it('only accepts paths inside the application', () => {
        expect(safeRedirect('/admin/user?page=2')).toBe('/admin/user?page=2')
        expect(safeRedirect('//evil.example')).toBeNull()
        expect(safeRedirect('/\\evil.example')).toBeNull()
        expect(safeRedirect('https://evil.example')).toBeNull()
        expect(safeRedirect(undefined)).toBeNull()
        expect(safeRedirect(['/admin'])).toBeNull()
    })
})

describe('installGuards', () => {
    const makeRouter = () => createRouter({
        history: createMemoryHistory(),
        routes: [
            { path: '/', name: 'site.home', component: Empty },
            { path: '/auth', component: Empty, meta: { guest: true }, children: [{ path: 'login', name: 'auth.login', component: Empty }] },
            {
                path: '/admin',
                component: Empty,
                meta: { auth: true },
                children: [
                    { path: '', name: 'admin.dashboard', component: Empty },
                    { path: 'user', name: 'AdminUsers', component: Empty, children: [{ path: ':id', name: 'AdminShowUser', component: Empty }] },
                ],
            },
        ],
    })

    it('redirects on real navigations and reports the admin denial', async () => {
        const session = { authenticated: false, isAdmin: false }
        const onDenied = vi.fn()
        const router = makeRouter()

        installGuards(router, { getSession: () => session, adminOnly: ['AdminUsers'], onDenied })

        await router.push('/admin/user/3')
        expect(router.currentRoute.value.name).toBe('auth.login')
        expect(router.currentRoute.value.query.redirect).toBe('/admin/user/3')

        session.authenticated = true

        await router.push('/admin/user/3')
        expect(router.currentRoute.value.name).toBe('admin.dashboard')
        expect(onDenied).toHaveBeenCalledWith('admin', expect.objectContaining({ name: 'AdminShowUser' }))

        await router.push('/auth/login')
        expect(router.currentRoute.value.name).toBe('admin.dashboard')

        session.isAdmin = true

        await router.push('/admin/user/3')
        expect(router.currentRoute.value.name).toBe('AdminShowUser')
    })
})
