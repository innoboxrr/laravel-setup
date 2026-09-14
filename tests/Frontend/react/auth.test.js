import { beforeEach, describe, expect, it, vi } from 'vitest'
import { setRoutes } from 'innoboxrr-route-resolver'

import { createErrorHandler, csrfCookieUrl, unauthenticatedHandler } from '@app/http.js'
import { createAuthStore } from '@app/stores/auth.js'

const session = { user: { id: 1, name: 'Ana', email: 'ana@example.com' }, authenticated: true, is_admin: false, verified: true, impersonating: false }

const fakeHttp = (calls) => ({
    get: vi.fn(async (url) => {
        calls.push(['get', url])

        return { data: url === 'auth.get.auth' ? session : {} }
    }),
    post: vi.fn(async (url, body) => {
        calls.push(['post', url, body])

        return { data: { success: true } }
    }),
})

const resolve = (name) => name

describe('auth store', () => {
    beforeEach(() => setRoutes({}))

    it('asks for the CSRF cookie before logging in, then loads the session', async () => {
        const calls = []
        const store = createAuthStore({ http: fakeHttp(calls), resolve, csrfUrl: () => '/sanctum/csrf-cookie' })

        await store.getState().login({ email: 'ana@example.com', password: 'secret', remember: true })

        expect(calls).toEqual([
            ['get', '/sanctum/csrf-cookie'],
            ['post', 'auth.login', { email: 'ana@example.com', password: 'secret', remember: true }],
            ['get', 'auth.get.auth'],
        ])

        expect(store.getState()).toMatchObject({ authenticated: true, user: session.user, verified: true })
    })

    // laravel-auth 6.1 sólo acepta POST: por GET otro sitio podía terminar la
    // suplantación con un <img>.
    it('reverts the impersonation with a POST, then loads the session', async () => {
        const calls = []
        const store = createAuthStore({ http: fakeHttp(calls), resolve })

        await expect(store.getState().revertImpersonation()).resolves.toEqual({ success: true })

        expect(calls).toEqual([
            ['post', 'auth.revert.impersonate', undefined],
            ['get', 'auth.get.auth'],
        ])
    })

    it('resolves the CSRF cookie by route name when routes.json has it', () => {
        expect(csrfCookieUrl()).toBe('/sanctum/csrf-cookie')

        setRoutes({ 'sanctum.csrf-cookie': 'sanctum/csrf-cookie' })

        expect(csrfCookieUrl()).toMatch(/^\/\/[^/]*\/sanctum\/csrf-cookie$/)
    })

    it('does not treat a failing session load as a signed-in user', async () => {
        const http = { get: vi.fn(async () => { throw new Error('offline') }) }
        const store = createAuthStore({ http, resolve })
        const error = vi.spyOn(console, 'error').mockImplementation(() => {})

        await store.getState().load()

        expect(store.getState()).toMatchObject({ authenticated: false, user: null, loaded: true })
        expect(http.get).toHaveBeenCalledWith('auth.get.auth', { skipAuthRedirect: true })

        error.mockRestore()
    })

    it('clears the session and goes to the login on a 401', async () => {
        const calls = []
        const store = createAuthStore({ http: fakeHttp(calls), resolve })

        await store.getState().load()
        expect(store.getState().authenticated).toBe(true)

        const navigate = vi.fn()
        const handler = createErrorHandler({
            http: vi.fn(),
            onUnauthenticated: unauthenticatedHandler({
                clearSession: () => store.getState().clear(),
                navigate,
                currentPath: () => '/admin/profile',
            }),
        })

        const error = { response: { status: 401 }, config: { url: '/api/app/user/update' } }

        await expect(handler(error)).rejects.toBe(error)

        expect(store.getState()).toMatchObject({ authenticated: false, user: null, is_admin: false })
        expect(navigate).toHaveBeenCalledWith('/auth/login?redirect=%2Fadmin%2Fprofile')
    })

    it('leaves the session alone on a 401 of a request that opted out', async () => {
        const onUnauthenticated = vi.fn()
        const handler = createErrorHandler({ http: vi.fn(), onUnauthenticated })

        await expect(handler({ response: { status: 401 }, config: { skipAuthRedirect: true } })).rejects.toBeTruthy()

        expect(onUnauthenticated).not.toHaveBeenCalled()
    })

    it('does not navigate again when already on an auth screen', () => {
        const navigate = vi.fn()
        const clearSession = vi.fn()

        unauthenticatedHandler({ clearSession, navigate, currentPath: () => '/auth/login?redirect=%2Fadmin' })()

        expect(clearSession).toHaveBeenCalled()
        expect(navigate).not.toHaveBeenCalled()
    })

    it('uploads the avatar as `file` and saves its relative uri as the avatar meta; removing sends an empty value', async () => {
        const calls = []
        const http = {
            ...fakeHttp(calls),
            post: vi.fn(async (url, body) => {
                calls.push(['post', url, body])

                return { data: { uuid: 'abc', url: 'https://app.test/lu/upload/abc/display/me.png', uri: '/lu/upload/abc/display/me.png' } }
            }),
            put: vi.fn(async (url, body) => {
                calls.push(['put', url, body])

                return { data: {} }
            }),
        }

        const store = createAuthStore({ http, resolve })

        await store.getState().load()

        const file = new File(['png'], 'me.png', { type: 'image/png' })

        await expect(store.getState().updateAvatar(file)).resolves.toBe('/lu/upload/abc/display/me.png')

        const [, uploadUrl, body] = calls.find(([method]) => method === 'post')

        expect(uploadUrl).toBe('lu.upload.file')
        expect(body.get('file')).toBeInstanceOf(File)
        expect(http.put).toHaveBeenCalledWith('api.app.user.update', { user_id: 1, avatar: '/lu/upload/abc/display/me.png' })

        await store.getState().removeAvatar()

        expect(http.put).toHaveBeenLastCalledWith('api.app.user.update', { user_id: 1, avatar: '' })
    })

    it('asks for a new CSRF cookie on a 419 and repeats the request once', async () => {
        const http = vi.fn(async () => ({ data: 'repeated' }))
        http.get = vi.fn(async () => ({}))

        const handler = createErrorHandler({ http, csrfUrl: () => '/sanctum/csrf-cookie' })
        const config = { url: '/api/laravel-options/option/update', method: 'put' }

        await expect(handler({ response: { status: 419 }, config })).resolves.toEqual({ data: 'repeated' })

        expect(http.get).toHaveBeenCalledWith('/sanctum/csrf-cookie')
        expect(http).toHaveBeenCalledWith({ ...config, csrfRetried: true })

        const second = { response: { status: 419 }, config: { ...config, csrfRetried: true } }

        await expect(handler(second)).rejects.toBe(second)
        expect(http).toHaveBeenCalledTimes(1)
    })
})
