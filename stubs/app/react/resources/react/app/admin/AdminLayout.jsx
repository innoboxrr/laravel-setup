import { useEffect, useMemo } from 'react'
import { Link, Outlet, useLocation } from 'react-router-dom'
import t from 'innoboxrr-i18n'
import { IconComponent } from 'innoboxrr-react-form-elements'

import ThemeToggle from '../components/ThemeToggle.jsx'
import { adminOnly } from '../config.js'
import { buildMenu } from '../router/menu.js'
import { useAuthStore } from '../stores/auth.js'
import { useNotificationsStore } from '../stores/notifications.js'
import { useSiteName } from '../stores/options.js'
import { useUiStore } from '../stores/ui.js'
import NotificationBell from './components/NotificationBell.jsx'
import { ImpersonationBanner, VerificationBanner } from './components/SessionBanners.jsx'
import SidebarMenu from './components/SidebarMenu.jsx'
import UserMenu from './components/UserMenu.jsx'

export default function AdminLayout({ moduleRoutes = [] }) {
    const isAdmin = useAuthStore((state) => state.is_admin)
    const sidebarOpen = useUiStore((state) => state.sidebarOpen)
    const setSidebarOpen = useUiStore((state) => state.setSidebarOpen)
    const siteName = useSiteName()
    const location = useLocation()

    const menu = useMemo(() => buildMenu({ moduleRoutes, isAdmin, adminOnly }), [moduleRoutes, isAdmin])

    useEffect(() => useNotificationsStore.getState().startPolling(), [])

    // En móvil la barra lateral tapa la pantalla: se cierra al navegar.
    useEffect(() => setSidebarOpen(false), [location.pathname, setSidebarOpen])

    useEffect(() => {
        if (! sidebarOpen) {
            return undefined
        }

        const onKeyDown = (event) => {
            if (event.key === 'Escape') {
                setSidebarOpen(false)
            }
        }

        document.addEventListener('keydown', onKeyDown)

        return () => document.removeEventListener('keydown', onKeyDown)
    }, [sidebarOpen, setSidebarOpen])

    return (
        <div className="fe-shell app-shell" data-sidebar-open={sidebarOpen ? 'true' : 'false'}>
            <a href="#app-main" className="app-skip-link">{t('Skip to content')}</a>

            <header className="fe-shell-header app-shell-header">
                <button
                    type="button"
                    className="fe-icon-button app-menu-toggle"
                    aria-controls="app-sidebar"
                    aria-expanded={sidebarOpen}
                    aria-label={sidebarOpen ? t('Close menu') : t('Open menu')}
                    onClick={() => setSidebarOpen(! sidebarOpen)}>
                    <IconComponent name={sidebarOpen ? 'close' : 'menu'} size={18} />
                </button>

                <Link to="/admin" className="app-brand">{siteName}</Link>

                <span className="app-spacer" />

                <NotificationBell />

                <ThemeToggle />

                <UserMenu />
            </header>

            <nav id="app-sidebar" className="fe-shell-sidebar" aria-label={t('Main menu')}>
                <SidebarMenu menu={menu} />
            </nav>

            {sidebarOpen ? <div className="app-shell-backdrop" aria-hidden="true" onClick={() => setSidebarOpen(false)} /> : null}

            <main id="app-main" className="fe-shell-main" tabIndex={-1}>
                <ImpersonationBanner />
                <VerificationBanner />

                <Outlet context={{ menu }} />
            </main>
        </div>
    )
}
