import { afterEach, beforeEach, describe, expect, it, vi } from 'vitest'
import axios, { AxiosError } from 'axios'
import { createPinia, setActivePinia } from 'pinia'
import { setRoutes } from 'innoboxrr-route-resolver'
import { configureAxios, createErrorHandler, errorMessage, installInterceptors } from '@app/http.js'
import { normalizeSession, useAuthStore } from '@app/stores/auth.js'
import routes from '../fixtures/routes.json'

const session = {
    user: { id: 1, name: 'Ana Torres', email: 'ana@example.com' },
    authenticated: true,
    is_admin: true,
    verified: false,
    impersonating: false,
}

const path = (url) => new URL(url, 'http://localhost').pathname

describe('useAuthStore', () => {
    beforeEach(() => {
        setRoutes(routes)
        setActivePinia(createPinia())
    })

    afterEach(() => {
        vi.restoreAllMocks()
    })

    it('loads the session from get-auth without triggering the 401 handling', async () => {
        const get = vi.spyOn(axios, 'get').mockResolvedValue({ data: session })
        const store = useAuthStore()

        await store.load()

        expect(path(get.mock.calls[0][0])).toBe('/auth/get-auth')
        expect(get.mock.calls[0][1]).toEqual({ skipAuthHandling: true })
        expect(store.user.name).toBe('Ana Torres')
        expect(store.authenticated).toBe(true)
        expect(store.isAdmin).toBe(true)
        expect(store.verified).toBe(false)
        expect(store.loaded).toBe(true)
    })

    it('clears the session when get-auth fails', async () => {
        vi.spyOn(axios, 'get').mockRejectedValue(new Error('offline'))
        const store = useAuthStore()

        await store.load()

        expect(store.authenticated).toBe(false)
        expect(store.user).toBeNull()
        expect(store.loaded).toBe(true)
    })

    it('asks for the CSRF cookie before posting the login, then reloads the session', async () => {
        const calls = []

        vi.spyOn(axios, 'get').mockImplementation(async (url) => {
            calls.push(`GET ${path(url)}`)

            return path(url) === '/auth/get-auth' ? { data: session } : { data: null }
        })

        vi.spyOn(axios, 'post').mockImplementation(async (url, data) => {
            calls.push(`POST ${path(url)} ${JSON.stringify(data)}`)

            return { data: { success: true } }
        })

        const store = useAuthStore()

        await store.login({ email: 'ana@example.com', password: 'secret', remember: 1 })

        expect(calls).toEqual([
            'GET /sanctum/csrf-cookie',
            'POST /auth/login {"email":"ana@example.com","password":"secret","remember":true}',
            'GET /auth/get-auth',
        ])
        expect(store.authenticated).toBe(true)
    })

    it('does not post the login when the CSRF cookie cannot be obtained', async () => {
        vi.spyOn(axios, 'get').mockRejectedValue(new Error('offline'))
        const post = vi.spyOn(axios, 'post')
        const store = useAuthStore()

        await expect(store.login({ email: 'a@b.c', password: 'x' })).rejects.toThrow('offline')
        expect(post).not.toHaveBeenCalled()
    })

    it('clears the session on logout even when the request fails', async () => {
        vi.spyOn(axios, 'get').mockResolvedValue({ data: session })
        vi.spyOn(axios, 'post').mockRejectedValue(new Error('offline'))
        const store = useAuthStore()

        await store.load()
        await expect(store.logout()).rejects.toThrow('offline')

        expect(store.authenticated).toBe(false)
    })

    it('normalizes a partial get-auth response', () => {
        expect(normalizeSession({ user: null, authenticated: true, is_admin: true })).toEqual({
            user: null,
            authenticated: false,
            is_admin: false,
            verified: false,
            impersonating: false,
        })
    })
})

describe('HTTP error handling', () => {
    beforeEach(() => {
        setRoutes(routes)
        setActivePinia(createPinia())
    })

    it('clears the session on a 401 outside load()', async () => {
        const store = useAuthStore()

        store.session = normalizeSession(session)

        const handler = createErrorHandler({ onUnauthorized: () => store.clear() })

        await expect(handler({ response: { status: 401 }, config: {} })).rejects.toMatchObject({ response: { status: 401 } })
        expect(store.authenticated).toBe(false)
        expect(store.user).toBeNull()
    })

    it('ignores the 401 of requests that expect no session', async () => {
        const onUnauthorized = vi.fn()
        const handler = createErrorHandler({ onUnauthorized })

        await expect(handler({ response: { status: 401 }, config: { skipAuthHandling: true } })).rejects.toBeTruthy()
        expect(onUnauthorized).not.toHaveBeenCalled()
    })

    it('asks for a new CSRF cookie on a 419 and repeats the request once', async () => {
        const instance = {
            get: vi.fn().mockResolvedValue({}),
            request: vi.fn().mockResolvedValue({ data: 'repeated' }),
        }
        const handler = createErrorHandler({ instance })
        const config = { url: '/api/app/user/update', method: 'put' }

        await expect(handler({ response: { status: 419 }, config })).resolves.toEqual({ data: 'repeated' })
        expect(path(instance.get.mock.calls[0][0])).toBe('/sanctum/csrf-cookie')
        expect(instance.request).toHaveBeenCalledWith(expect.objectContaining({ csrfRetried: true }))

        await expect(handler({ response: { status: 419 }, config })).rejects.toBeTruthy()
        expect(instance.request).toHaveBeenCalledTimes(1)
    })

    it('runs the handler as a real axios interceptor', async () => {
        const instance = configureAxios(axios.create({
            adapter: async (config) => {
                throw new AxiosError('Unauthenticated.', 'ERR_BAD_REQUEST', config, null, {
                    status: 401,
                    data: { message: 'Unauthenticated.' },
                    headers: {},
                    config,
                })
            },
        }))
        const onUnauthorized = vi.fn()

        installInterceptors({ instance, onUnauthorized })

        await expect(instance.get('/api/app/user/index')).rejects.toBeInstanceOf(AxiosError)
        expect(onUnauthorized).toHaveBeenCalledTimes(1)
        expect(instance.defaults.withXSRFToken).toBe(true)
        expect(instance.defaults.headers.common['X-Requested-With']).toBe('XMLHttpRequest')
    })

    it('words the errors that do not belong to a field', () => {
        const t = (key) => key

        expect(errorMessage({}, t)).toBe('Could not connect to the server.')
        expect(errorMessage({ response: { status: 429, data: {} } }, t)).toBe('Too many attempts. Try again in a moment.')
        expect(errorMessage({ response: { status: 403, data: { message: 'This action is unauthorized.' } } }, t)).toBe('You are not allowed to do this.')
        expect(errorMessage({ response: { status: 500, data: { message: 'Server Error' } } }, t)).toBe('Server Error')
    })
})
