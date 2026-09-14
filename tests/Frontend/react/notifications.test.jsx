import { afterEach, describe, expect, it, vi } from 'vitest'
import { act, fireEvent, render, screen } from '@testing-library/react'
import { MemoryRouter } from 'react-router-dom'

import NotificationBell from '@app/admin/components/NotificationBell.jsx'
import { createNotificationsStore, resolveAction, useNotificationsStore } from '@app/stores/notifications.js'

const payload = '<img src=x onerror="window.__pwned = true">'

describe('notifications', () => {
    afterEach(() => {
        useNotificationsStore.getState().reset()
        delete window.__pwned
    })

    it('renders data.message as text, never as HTML', async () => {
        useNotificationsStore.setState({
            count: 1,
            items: [{ id: 'n1', data: { message: payload, action: '/admin/user/1' }, read_at: null, created_at: '2026-09-13T10:00:00Z' }],
            fetchLatest: vi.fn(async () => {}),
        })

        const { container } = render(
            <MemoryRouter>
                <NotificationBell />
            </MemoryRouter>
        )

        await act(async () => {
            fireEvent.click(screen.getByRole('button', { name: 'Notifications, 1 unread' }))
        })

        expect(screen.getByText(payload)).toBeInTheDocument()
        expect(container.querySelector('img')).toBeNull()
        expect(window.__pwned).toBeUndefined()
    })

    it('opens internal paths with the router, http(s) URLs with location, and ignores the rest', () => {
        expect(resolveAction('/admin/user/1')).toEqual({ type: 'router', to: '/admin/user/1' })
        expect(resolveAction('https://example.com/export.xlsx')).toEqual({ type: 'location', href: 'https://example.com/export.xlsx' })
        expect(resolveAction('HTTP://example.com')).toEqual({ type: 'location', href: 'HTTP://example.com' })
        expect(resolveAction('//example.com')).toBeNull()
        expect(resolveAction('/\\example.com')).toBeNull()
        expect(resolveAction('javascript:alert(1)')).toBeNull()
        expect(resolveAction('mailto:ana@example.com')).toBeNull()
        expect(resolveAction('')).toBeNull()
        expect(resolveAction(null)).toBeNull()
    })

    it('marks one as read and lowers the unread count', async () => {
        const http = {
            post: vi.fn(async () => ({ data: { success: true, id: 'n1', action: '/admin', read_at: '2026-09-13T10:01:00.000000Z' } })),
        }
        const store = createNotificationsStore({ http, resolve: (name, params) => `${name}:${params?.notificationId ?? ''}` })

        store.setState({ count: 2, items: [{ id: 'n1', data: {}, read_at: null }, { id: 'n2', data: {}, read_at: null }] })

        const target = await store.getState().markAsRead(store.getState().items[0])

        expect(http.post).toHaveBeenCalledWith('innoboxrr.notifications.mark.as.read:n1')
        expect(target).toEqual({ type: 'router', to: '/admin' })
        expect(store.getState().count).toBe(1)
        expect(store.getState().items[0].read_at).toBe('2026-09-13T10:01:00.000000Z')
    })
})
