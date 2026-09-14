import { useEffect, useId, useRef, useState } from 'react'
import { useNavigate } from 'react-router-dom'
import t, { getLocale } from 'innoboxrr-i18n'
import { notifyError } from 'innoboxrr-form-core'
import { IconComponent } from 'innoboxrr-react-form-elements'

import { messageOf, useNotificationsStore } from '../../stores/notifications.js'

const formatDate = (value) => {
    const date = value ? new Date(value) : null

    if (! date || Number.isNaN(date.getTime())) {
        return ''
    }

    try {
        return new Intl.DateTimeFormat(getLocale(), { dateStyle: 'medium', timeStyle: 'short' }).format(date)
    } catch {
        return date.toLocaleString()
    }
}

/**
 * La campana: el contador de no leídas y, al abrirla, las últimas.
 *
 * `data.message` llega de quien envía la notificación, que puede incluir texto
 * de un usuario: se pinta como texto, nunca como HTML.
 */
export default function NotificationBell() {
    const count = useNotificationsStore((state) => state.count)
    const items = useNotificationsStore((state) => state.items)
    const loading = useNotificationsStore((state) => state.loading)
    const fetchLatest = useNotificationsStore((state) => state.fetchLatest)
    const markAsRead = useNotificationsStore((state) => state.markAsRead)
    const markAllAsRead = useNotificationsStore((state) => state.markAllAsRead)

    const navigate = useNavigate()
    const panelId = useId()
    const wrapper = useRef(null)
    const button = useRef(null)
    const [open, setOpen] = useState(false)

    useEffect(() => {
        if (! open) {
            return undefined
        }

        fetchLatest().catch(() => notifyError(t('The notifications could not be loaded.')))

        const onPointerDown = (event) => {
            if (! wrapper.current?.contains(event.target)) {
                setOpen(false)
            }
        }

        const onKeyDown = (event) => {
            if (event.key === 'Escape') {
                setOpen(false)
                button.current?.focus()
            }
        }

        document.addEventListener('pointerdown', onPointerDown)
        document.addEventListener('keydown', onKeyDown)

        return () => {
            document.removeEventListener('pointerdown', onPointerDown)
            document.removeEventListener('keydown', onKeyDown)
        }
    }, [open, fetchLatest])

    const choose = async (notification) => {
        setOpen(false)

        try {
            const target = await markAsRead(notification)

            if (target?.type === 'router') {
                navigate(target.to)
            } else if (target?.type === 'location') {
                window.location.assign(target.href)
            }
        } catch {
            notifyError(t('The notification could not be marked as read.'))
        }
    }

    const markAll = async () => {
        try {
            await markAllAsRead()
        } catch {
            notifyError(t('The notifications could not be marked as read.'))
        }
    }

    return (
        <div className="app-bell" ref={wrapper}>
            <button
                ref={button}
                type="button"
                className="fe-icon-button app-bell-button"
                aria-expanded={open}
                aria-controls={panelId}
                aria-label={count > 0 ? t('Notifications, :count unread', { count }) : t('Notifications')}
                onClick={() => setOpen((value) => ! value)}>
                <IconComponent name="mdi:bell-outline" size={18} />
                {count > 0 ? <span className="app-bell-count" aria-hidden="true">{count > 99 ? '99+' : count}</span> : null}
            </button>

            {open ? (
                <div id={panelId} className="app-bell-panel" role="region" aria-label={t('Notifications')}>
                    <div className="app-bell-head">
                        <strong>{t('Notifications')}</strong>

                        <button type="button" className="fe-button-link" disabled={count === 0} onClick={markAll}>
                            {t('Mark all as read')}
                        </button>
                    </div>

                    {items.length === 0 ? (
                        <p className="app-bell-empty">{loading ? t('Loading…') : t('You have no notifications.')}</p>
                    ) : (
                        <ul className="app-bell-list">
                            {items.map((notification) => (
                                <li key={notification.id}>
                                    <button
                                        type="button"
                                        className="app-bell-item"
                                        data-unread={notification.read_at ? 'false' : 'true'}
                                        onClick={() => choose(notification)}>
                                        <span className="app-bell-message">{messageOf(notification) || t('New notification')}</span>

                                        <time className="app-bell-time" dateTime={notification.created_at ?? undefined}>
                                            {formatDate(notification.created_at)}
                                        </time>

                                        {notification.read_at ? null : <span className="app-sr-only">{t('Unread')}</span>}
                                    </button>
                                </li>
                            ))}
                        </ul>
                    )}
                </div>
            ) : null}
        </div>
    )
}
