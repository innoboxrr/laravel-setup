import { afterEach, beforeEach, describe, expect, it, vi } from 'vitest'
import axios from 'axios'
import { flushPromises, mount } from '@vue/test-utils'
import { createPinia, setActivePinia } from 'pinia'
import { createMemoryHistory, createRouter } from 'vue-router'
import { setRoutes } from 'innoboxrr-route-resolver'
import NotificationsBell from '@app/admin/components/NotificationsBell.vue'
import { resolveAction, startUnreadPolling, useNotificationsStore } from '@app/stores/notifications.js'
import routes from '../fixtures/routes.json'

const payload = '<img src=x onerror="window.__bellXss = true">'

const notifications = [
    { id: 'n1', data: { message: payload, action: '/admin/profile' }, read_at: null, created_at: '2026-09-13T10:00:00Z' },
    { id: 'n2', data: { message: 'Tu exportación está lista' }, read_at: '2026-09-12T09:00:00Z', created_at: '2026-09-12T08:00:00Z' },
]

const path = (url) => new URL(url, 'http://localhost').pathname

const Empty = { render: () => null }

let router

const mountBell = () => mount(NotificationsBell, {
    attachTo: document.body,
    global: { plugins: [router] },
})

describe('NotificationsBell', () => {
    beforeEach(async () => {
        setRoutes(routes)
        setActivePinia(createPinia())

        router = createRouter({
            history: createMemoryHistory(),
            routes: [
                { path: '/admin', name: 'admin.dashboard', component: Empty },
                { path: '/admin/profile', name: 'admin.profile', component: Empty },
            ],
        })

        await router.push('/admin')

        vi.spyOn(axios, 'get').mockImplementation(async (url) => {
            if (path(url).endsWith('/unread/count')) {
                return { data: { count: 1 } }
            }

            return { data: notifications }
        })
    })

    afterEach(() => {
        vi.restoreAllMocks()
        document.body.innerHTML = ''
        delete window.__bellXss
    })

    it('renders data.message as text, never as HTML', async () => {
        const wrapper = mountBell()

        await wrapper.find('.app-bell-button').trigger('click')
        await flushPromises()

        const messages = wrapper.findAll('.app-bell-message')

        expect(messages.map((node) => node.text())).toEqual([payload, 'Tu exportación está lista'])
        expect(messages[0].element.innerHTML).toBe('&lt;img src=x onerror="window.__bellXss = true"&gt;')
        expect(wrapper.find('.app-bell-panel img').exists()).toBe(false)
        expect(window.__bellXss).toBeUndefined()

        wrapper.unmount()
    })

    it('asks for the latest notifications with a limit when it opens', async () => {
        const wrapper = mountBell()

        await wrapper.find('.app-bell-button').trigger('click')
        await flushPromises()

        const url = axios.get.mock.calls.at(-1)[0]

        expect(path(url)).toBe('/innoboxrr/notifications/notifications')
        expect(url).toContain('limit=10')
        expect(wrapper.find('.app-bell-button').attributes('aria-expanded')).toBe('true')

        wrapper.unmount()
    })

    it('shows the unread count and marks one as read before going to its action', async () => {
        const post = vi.spyOn(axios, 'post').mockResolvedValue({ data: { success: true, id: 'n1', action: '/admin/profile', read_at: '2026-09-13T11:00:00Z' } })
        const store = useNotificationsStore()

        await store.fetchUnreadCount()

        const wrapper = mountBell()

        expect(wrapper.find('.app-bell-count').text()).toBe('1')
        expect(wrapper.find('.app-bell-button').attributes('aria-label')).toBe('Notifications, 1 unread')

        await wrapper.find('.app-bell-button').trigger('click')
        await flushPromises()
        await wrapper.find('.app-bell-item[data-unread="true"]').trigger('click')
        await flushPromises()

        expect(path(post.mock.calls[0][0])).toBe('/innoboxrr/notifications/notifications/n1/markAsRead')
        expect(store.unread).toBe(0)
        expect(router.currentRoute.value.name).toBe('admin.profile')
        expect(wrapper.find('.app-bell-panel').exists()).toBe(false)

        wrapper.unmount()
    })

    it('marks all as read', async () => {
        const post = vi.spyOn(axios, 'post').mockResolvedValue({ data: { success: true, count: 1 } })
        const wrapper = mountBell()

        await wrapper.find('.app-bell-button').trigger('click')
        await flushPromises()
        await wrapper.find('.app-bell-head button').trigger('click')
        await flushPromises()

        expect(path(post.mock.calls[0][0])).toBe('/innoboxrr/notifications/notifications/markAsRead')
        expect(wrapper.findAll('.app-bell-item[data-unread="true"]')).toHaveLength(0)

        wrapper.unmount()
    })

    it('closes with Escape and gives the focus back to the button', async () => {
        const wrapper = mountBell()

        await wrapper.find('.app-bell-button').trigger('click')
        await flushPromises()
        await wrapper.find('.app-bell').trigger('keydown', { key: 'Escape' })
        await flushPromises()

        expect(wrapper.find('.app-bell-panel').exists()).toBe(false)
        expect(document.activeElement).toBe(wrapper.find('.app-bell-button').element)

        wrapper.unmount()
    })
})

describe('notifications helpers', () => {
    it('sends internal routes to the router and absolute URLs to location', () => {
        expect(resolveAction('/admin/user/5')).toEqual({ type: 'router', to: '/admin/user/5' })
        expect(resolveAction('https://app.example.com/export.xlsx')).toEqual({ type: 'location', href: 'https://app.example.com/export.xlsx' })
        expect(resolveAction('//evil.example')).toBeNull()
        expect(resolveAction('javascript:alert(1)')).toBeNull()
        expect(resolveAction(null)).toBeNull()
    })

    it('polls the unread count on start, every minute and when the tab comes back', async () => {
        vi.useFakeTimers()

        const store = { fetchUnreadCount: vi.fn().mockResolvedValue(0) }
        const doc = new EventTarget()

        doc.visibilityState = 'visible'

        const stop = startUnreadPolling(store, { doc })

        expect(store.fetchUnreadCount).toHaveBeenCalledTimes(1)

        vi.advanceTimersByTime(60_000)
        expect(store.fetchUnreadCount).toHaveBeenCalledTimes(2)

        doc.dispatchEvent(new Event('visibilitychange'))
        expect(store.fetchUnreadCount).toHaveBeenCalledTimes(3)

        doc.visibilityState = 'hidden'
        doc.dispatchEvent(new Event('visibilitychange'))
        expect(store.fetchUnreadCount).toHaveBeenCalledTimes(3)

        stop()
        vi.advanceTimersByTime(120_000)
        expect(store.fetchUnreadCount).toHaveBeenCalledTimes(3)

        vi.useRealTimers()
    })
})
