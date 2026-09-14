import axios from 'axios'
import { create } from 'zustand'
import route from 'innoboxrr-route-resolver'

import { notificationsInterval } from '../config.js'

/**
 * A dónde lleva una notificación: una ruta de la SPA con el router y una URL
 * http(s) con `location`. `//host` no es interna, y un `javascript:` no lleva a
 * ninguna parte.
 *
 * @returns {{ type: 'router', to: string } | { type: 'location', href: string } | null}
 */
export function resolveAction(action) {
    if (typeof action !== 'string' || action.trim() === '') {
        return null
    }

    const value = action.trim()

    if (value.startsWith('/') && ! value.startsWith('//') && ! value.startsWith('/\\')) {
        return { type: 'router', to: value }
    }

    if (/^https?:\/\//i.test(value)) {
        return { type: 'location', href: value }
    }

    return null
}

export const messageOf = (notification) => {
    const message = notification?.data?.message ?? notification?.data?.title

    return message === undefined || message === null ? '' : String(message)
}

/**
 * Las notificaciones de laravel-notifications 2.1.
 *
 * @param {{ http?: any, resolve?: typeof route }} deps
 */
export function createNotificationsStore({ http = axios, resolve = route } = {}) {
    return create((set, get) => ({
        count: 0,
        items: [],
        loading: false,

        fetchCount: async () => {
            const { data } = await http.get(resolve('innoboxrr.notifications.index.unread.count'))

            set({ count: Number(data?.count ?? 0) })
        },

        fetchLatest: async (limit = 10) => {
            set({ loading: true })

            try {
                const { data } = await http.get(resolve('innoboxrr.notifications.index', { limit }))

                set({ items: Array.isArray(data) ? data : [] })
            } finally {
                set({ loading: false })
            }
        },

        markAsRead: async (notification) => {
            const { data } = await http.post(resolve('innoboxrr.notifications.mark.as.read', { notificationId: notification.id }))

            set((state) => ({
                items: state.items.map((item) => (item.id === notification.id
                    ? { ...item, read_at: data?.read_at ?? new Date().toJSON() }
                    : item)),
                count: notification.read_at ? state.count : Math.max(0, state.count - 1),
            }))

            return resolveAction(data?.action ?? notification.data?.action)
        },

        markAllAsRead: async () => {
            await http.post(resolve('innoboxrr.notifications.mark.all.as.read'))

            set((state) => ({
                count: 0,
                items: state.items.map((item) => (item.read_at ? item : { ...item, read_at: new Date().toJSON() })),
            }))
        },

        /**
         * El contador al empezar, cada `interval` y al volver a la pestaña.
         * Devuelve la función que lo detiene.
         */
        startPolling: (interval = notificationsInterval) => {
            const refresh = () => get().fetchCount().catch(() => {})

            const onVisibility = () => {
                if (document.visibilityState === 'visible') {
                    refresh()
                }
            }

            refresh()

            const timer = setInterval(refresh, interval)

            document.addEventListener('visibilitychange', onVisibility)

            return () => {
                clearInterval(timer)
                document.removeEventListener('visibilitychange', onVisibility)
            }
        },

        reset: () => set({ count: 0, items: [], loading: false }),
    }))
}

export const useNotificationsStore = createNotificationsStore()
