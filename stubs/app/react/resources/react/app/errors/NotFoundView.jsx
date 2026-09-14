import { Link } from 'react-router-dom'
import t from 'innoboxrr-i18n'

import { useAuthStore } from '../stores/auth.js'

export default function NotFoundView() {
    const authenticated = useAuthStore((state) => state.authenticated)

    return (
        <main className="app-error">
            <p className="app-error-code">404</p>

            <h1 className="app-error-title">{t('Page not found')}</h1>

            <p className="app-error-text">{t('The page you are looking for does not exist or was moved.')}</p>

            <div className="app-error-actions">
                <Link to="/" className="fe-button">{t('Go to the home page')}</Link>

                {authenticated ? <Link to="/admin" className="fe-button-secondary">{t('Go to the admin panel')}</Link> : null}
            </div>
        </main>
    )
}
