import { afterEach, beforeEach, describe, expect, it, vi } from 'vitest'
import { act, fireEvent, render, screen, within } from '@testing-library/react'
import { createMemoryRouter, RouterProvider } from 'react-router-dom'

import { buildRoutes } from '@app/router/index.jsx'
import { useAuthStore } from '@app/stores/auth.js'
import { useNotificationsStore } from '@app/stores/notifications.js'
import { useOptionsStore } from '@app/stores/options.js'

import { optionsWithIds } from './helpers.js'

const Stub = () => <p>Users table</p>

const moduleRoutes = [
    { path: 'user', id: 'AdminUsers', handle: { title: 'Users', auth: true }, Component: Stub },
]

const signedIn = {
    user: { id: 1, name: 'Ana Torres', email: 'ana@example.com', payload: {} },
    authenticated: true,
    is_admin: true,
    verified: false,
    impersonating: true,
    loaded: true,
}

const mount = (path) => {
    const router = createMemoryRouter(buildRoutes({ moduleRoutes }), { initialEntries: [path] })

    render(<RouterProvider router={router} />)

    return router
}

/*
 * Cada pantalla montada de verdad, con el árbol de rutas real: lo que las
 * pruebas unitarias no ven (un hook fuera de su proveedor, un import roto).
 */
describe('screens', () => {
    beforeEach(() => {
        useOptionsStore.getState().hydrate(optionsWithIds())
        useNotificationsStore.setState({ startPolling: () => () => {}, count: 0, items: [] })
    })

    afterEach(() => {
        useAuthStore.getState().clear()
        document.cookie = 'cookie_consent=; max-age=0; path=/'
    })

    it('renders the seeded home page with its title, the content inside <main>', async () => {
        mount('/')

        const hero = await screen.findByRole('heading', { level: 1, name: 'Tu aplicación, lista para crecer' })

        expect(screen.getByRole('main')).toContainElement(hero)
        expect(screen.getByRole('main')).not.toContainElement(document.querySelector('header.site-header'))
        expect(screen.getByRole('main')).not.toContainElement(document.querySelector('footer.site-footer'))
        expect(document.title).toBe('Inicio · Mi aplicación')
    })

    it('shows "This page has no content yet" for a page missing from theme', async () => {
        const options = optionsWithIds().map((option) => {
            if (option.key !== 'theme') {
                return option
            }

            const { terms, ...theme } = JSON.parse(option.value)

            return { ...option, value: JSON.stringify(theme) }
        })

        useOptionsStore.getState().hydrate(options)

        mount('/terms')

        expect(await screen.findByRole('heading', { level: 1, name: 'This page has no content yet' })).toBeInTheDocument()
    })

    it('says so when registration is closed (403)', async () => {
        useAuthStore.setState({ register: vi.fn(async () => { throw { response: { status: 403, data: { message: 'This action is unauthorized.' } } } }) })

        mount('/auth/register')

        await screen.findByRole('heading', { level: 1, name: 'Create an account' })

        fireEvent.change(screen.getByLabelText('Name'), { target: { value: 'Ana' } })
        fireEvent.change(screen.getByLabelText('Email'), { target: { value: 'ana@example.com' } })
        fireEvent.change(screen.getByLabelText('Password'), { target: { value: 'secret123' } })
        fireEvent.change(screen.getByLabelText('Confirm password'), { target: { value: 'secret123' } })

        await act(async () => {
            fireEvent.click(screen.getByRole('button', { name: 'Create account' }))
        })

        expect(await screen.findByText('New accounts are not being accepted right now.')).toBeInTheDocument()
    })

    it.each([
        ['/auth/login', 'Log in'],
        ['/auth/register', 'Create an account'],
        ['/auth/forgot-password', 'Forgot your password?'],
        ['/auth/reset-password/token123/ana%40example.com', 'Choose a new password'],
    ])('renders %s for guests', async (path, heading) => {
        mount(path)

        expect(await screen.findByRole('heading', { level: 1, name: heading })).toBeInTheDocument()
    })

    it('prefills the email of the reset link, decoded', async () => {
        mount('/auth/reset-password/token123/ana%40example.com')

        expect(await screen.findByDisplayValue('ana@example.com')).toBeInTheDocument()
    })

    it('renders the admin shell with the menu, the banners and the dashboard cards', async () => {
        useAuthStore.setState(signedIn)

        mount('/admin')

        expect(await screen.findByRole('heading', { level: 1, name: 'Hello, Ana Torres' })).toBeInTheDocument()

        const nav = screen.getByRole('navigation', { name: 'Main menu' })

        expect(nav.textContent).toContain('Home')
        expect(nav.textContent).toContain('Administration')
        expect(within(nav).getByRole('link', { name: /Logs/ })).toHaveAttribute('target', '_blank')
        expect(within(nav).getByRole('link', { name: 'Users' })).toHaveAttribute('href', '/admin/user')
        expect(screen.getByText('You are viewing the account of Ana Torres.')).toBeInTheDocument()
        expect(screen.getByRole('button', { name: 'Resend the verification email' })).toBeInTheDocument()
        expect(screen.getByRole('button', { name: 'Open menu' })).toHaveAttribute('aria-expanded', 'false')
        expect(document.title).toBe('Home · Mi aplicación')
    })

    it('loads the profile and the site editor on demand', async () => {
        useAuthStore.setState(signedIn)

        const router = mount('/admin/profile')

        expect(await screen.findByRole('heading', { level: 1, name: 'Profile' })).toBeInTheDocument()
        expect(screen.getByDisplayValue('ana@example.com')).toBeInTheDocument()

        await router.navigate('/admin/site')

        expect(await screen.findByRole('tab', { name: 'Home' })).toBeInTheDocument()
    })

    it('mounts the module routes inside the shell', async () => {
        useAuthStore.setState(signedIn)

        mount('/admin/user')

        expect(await screen.findByText('Users table')).toBeInTheDocument()
    })

    it('renders the 404 for unknown routes', async () => {
        const warn = vi.spyOn(console, 'warn').mockImplementation(() => {})

        mount('/nothing/here')

        expect(await screen.findByRole('heading', { name: 'Page not found' })).toBeInTheDocument()

        warn.mockRestore()
    })
})
