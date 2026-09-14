import { describe, expect, it, vi } from 'vitest'
import { createMemoryRouter } from 'react-router-dom'

import { checkAccess, createGuardLoader, requirementsFor, safeRedirect, withGuards } from '@app/router/guards.js'
import { buildRoutes } from '@app/router/index.jsx'

const guest = { authenticated: false, is_admin: false }
const member = { authenticated: true, is_admin: false }
const admin = { authenticated: true, is_admin: true }

const Stub = () => null

// La forma de las rutas que genera LaraPack para User: id, handle con título
// y auth, y el detalle como hija.
const moduleRoutes = () => [
    {
        path: 'user',
        id: 'AdminUsers',
        handle: { title: 'Users', auth: true },
        Component: Stub,
        children: [
            { path: ':id', id: 'AdminShowUser', handle: { title: 'User', auth: true }, Component: Stub },
        ],
    },
    { path: 'posts', id: 'AdminPosts', handle: { title: 'Posts', auth: true }, Component: Stub },
]

const loaderArgs = (url) => ({ request: new Request(url), params: {} })

const runLoader = (loader, url) => {
    try {
        return { value: loader(loaderArgs(url)) }
    } catch (thrown) {
        return { redirect: thrown.headers.get('Location'), status: thrown.status }
    }
}

describe('guards', () => {
    it('sends a signed-in user away from guest routes', () => {
        const requirements = requirementsFor({ handle: { guest: true } })

        expect(checkAccess(requirements, member, '/auth/login')).toEqual({ reason: 'guest', redirect: '/admin' })
        expect(checkAccess(requirements, guest, '/auth/login')).toBeNull()
    })

    it('sends a guest to the login with the requested route, query included', () => {
        const loader = createGuardLoader(requirementsFor({ handle: { auth: true } }), { getSession: () => guest })

        const result = runLoader(loader, 'http://localhost/admin/profile?tab=password')

        expect(result.status).toBe(302)
        expect(result.redirect).toBe('/auth/login?redirect=%2Fadmin%2Fprofile%3Ftab%3Dpassword')
        expect(runLoader(createGuardLoader(requirementsFor({ handle: { auth: true } }), { getSession: () => member }), 'http://localhost/admin').value).toBeNull()
    })

    it('requires is_admin for admin routes and sends the rest to /admin with a notice', () => {
        const onDenied = vi.fn()
        const loader = createGuardLoader(requirementsFor({ handle: { admin: true } }), { getSession: () => member, onDenied })

        expect(runLoader(loader, 'http://localhost/admin/site').redirect).toBe('/admin')
        expect(onDenied).toHaveBeenCalledWith({ reason: 'admin', redirect: '/admin' })

        // Una ruta de administrador también exige sesión.
        expect(checkAccess(requirementsFor({ handle: { admin: true } }), guest, '/admin/site').reason).toBe('auth')
        expect(checkAccess(requirementsFor({ handle: { admin: true } }), admin, '/admin/site')).toBeNull()
    })

    it('applies adminOnly by route id, and to its children too', () => {
        const onDenied = vi.fn()
        const [users, posts] = withGuards(moduleRoutes(), { adminOnly: ['AdminUsers'], getSession: () => member, onDenied })

        expect(runLoader(users.loader, 'http://localhost/admin/user').redirect).toBe('/admin')
        expect(runLoader(users.children[0].loader, 'http://localhost/admin/user/7').redirect).toBe('/admin')
        expect(runLoader(posts.loader, 'http://localhost/admin/posts').value).toBeNull()
        expect(onDenied).toHaveBeenCalledTimes(2)

        const [adminUsers] = withGuards(moduleRoutes(), { adminOnly: ['AdminUsers'], getSession: () => admin })

        expect(runLoader(adminUsers.children[0].loader, 'http://localhost/admin/user/7').value).toBeNull()
    })

    it('keeps the translated title getter of module routes', () => {
        let calls = 0
        const route = { path: 'user', id: 'AdminUsers', handle: { get title() { calls += 1; return `Users ${calls}` } } }

        const [guarded] = withGuards([route], { getSession: () => admin })

        expect(guarded.handle.title).toBe('Users 1')
        expect(guarded.handle.title).toBe('Users 2')
    })

    it('only accepts internal redirects', () => {
        expect(safeRedirect('/admin/user?page=2')).toBe('/admin/user?page=2')
        expect(safeRedirect('//evil.example')).toBe('/admin')
        expect(safeRedirect('https://evil.example')).toBe('/admin')
        expect(safeRedirect(null)).toBe('/admin')
    })

    describe('the real route tree', () => {
        const router = (session, onDenied = vi.fn()) => createMemoryRouter(
            buildRoutes({ moduleRoutes: moduleRoutes(), adminOnly: ['AdminUsers'], getSession: () => session, onDenied }),
            { initialEntries: ['/'] },
        )

        it('lets anyone see the site pages and sends unknown routes to not-found', async () => {
            const app = router(guest)

            await app.navigate('/privacy')
            expect(app.state.matches.at(-1).route.id).toBe('site.privacy')

            await app.navigate('/does-not-exist')
            expect(app.state.matches.at(-1).route.id).toBe('not-found')
        })

        it('sends a guest from a module route to the login and back', async () => {
            const app = router(guest)

            await app.navigate('/admin/user/5')

            expect(app.state.location.pathname).toBe('/auth/login')
            expect(app.state.location.search).toBe('?redirect=%2Fadmin%2Fuser%2F5')
        })

        it('keeps a signed-in user away from the auth screens', async () => {
            const app = router(member)

            await app.navigate('/auth/register')

            expect(app.state.location.pathname).toBe('/admin')
        })

        it('keeps non-admins out of adminOnly module routes and the site editor', async () => {
            const onDenied = vi.fn()
            const app = router(member, onDenied)

            await app.navigate('/admin/user')
            expect(app.state.location.pathname).toBe('/admin')

            await app.navigate('/admin/site')
            expect(app.state.location.pathname).toBe('/admin')

            await app.navigate('/admin/posts')
            expect(app.state.location.pathname).toBe('/admin/posts')

            expect(onDenied).toHaveBeenCalledWith({ reason: 'admin', redirect: '/admin' })
        })

        it('lets an admin in', async () => {
            const app = router(admin)

            await app.navigate('/admin/user/5')
            expect(app.state.matches.at(-1).route.id).toBe('AdminShowUser')

            await app.navigate('/admin/site')
            expect(app.state.matches.at(-1).route.id).toBe('admin.site')
        })
    })
})
