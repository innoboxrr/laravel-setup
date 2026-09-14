import { ref } from 'vue'
import { defineStore } from 'pinia'
import { apiUrl, http } from '@app/http.js'

/**
 * Las rutas de laravel-notifications 2.1: prefijo `innoboxrr.notifications.`.
 */
export const NOTIFICATION_ROUTES = {
    latest: 'innoboxrr.notifications.index',
    unreadCount: 'innoboxrr.notifications.index.unread.count',
    markAsRead: 'innoboxrr.notifications.mark.as.read',
    markAllAsRead: 'innoboxrr.notifications.mark.all.as.read',
}

export const LATEST_LIMIT = 10

export const POLL_INTERVAL = 60_000

export function notificationMessage(notification) {
    const data = notification?.data

    if (! data || typeof data !== 'object') {
        return ''
    }

    const message = data.message ?? data.title ?? ''

    return typeof message === 'string' ? message : String(message)
}

/**
 * A dónde lleva una notificación: una ruta interna (`/admin/...`) con el
 * router; cualquier otra URL con location. `//host` no es interna, y un
 * `javascript:` no lleva a ninguna parte.
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

export const useNotificationsStore = defineStore('app.notifications', () => {
    const unread = ref(0)
    const items = ref([])
    const loading = ref(false)

    const fetchUnreadCount = async () => {
        const response = await http.get(apiUrl(NOTIFICATION_ROUTES.unreadCount))

        unread.value = Number(response.data?.count ?? 0)

        return unread.value
    }

    const fetchLatest = async (limit = LATEST_LIMIT) => {
        loading.value = true

        try {
            const response = await http.get(apiUrl(NOTIFICATION_ROUTES.latest, { limit }))

            items.value = Array.isArray(response.data) ? response.data : []
        } finally {
            loading.value = false
        }

        return items.value
    }

    /**
     * Marca una como leída y devuelve su acción.
     */
    const markAsRead = async (notification) => {
        const response = await http.post(apiUrl(NOTIFICATION_ROUTES.markAsRead, { notificationId: notification.id }))
        const readAt = response.data?.read_at ?? new Date().toISOString()

        if (! notification.read_at && unread.value > 0) {
            unread.value -= 1
        }

        items.value = items.value.map((item) => item.id === notification.id ? { ...item, read_at: item.read_at ?? readAt } : item)

        return response.data?.action ?? notification.data?.action ?? null
    }

    const markAllAsRead = async () => {
        await http.post(apiUrl(NOTIFICATION_ROUTES.markAllAsRead))

        const now = new Date().toISOString()

        unread.value = 0
        items.value = items.value.map((item) => ({ ...item, read_at: item.read_at ?? now }))
    }

    const reset = () => {
        unread.value = 0
        items.value = []
    }

    return { unread, items, loading, fetchUnreadCount, fetchLatest, markAsRead, markAllAsRead, reset }
})

/**
 * El contador se pide al montar el administrador, cada minuto y al volver a la
 * pestaña. Devuelve la función que lo detiene.
 */
export function startUnreadPolling(store, { interval = POLL_INTERVAL, doc = document } = {}) {
    // Un fallo aquí no es para el usuario: el siguiente intento lo repite, y un
    // 401 ya lo atiende el interceptor.
    const refresh = () => store.fetchUnreadCount().catch(() => {})

    const onVisibility = () => {
        if (doc.visibilityState === 'visible') {
            refresh()
        }
    }

    refresh()

    const timer = setInterval(refresh, interval)

    doc.addEventListener('visibilitychange', onVisibility)

    return () => {
        clearInterval(timer)
        doc.removeEventListener('visibilitychange', onVisibility)
    }
}
