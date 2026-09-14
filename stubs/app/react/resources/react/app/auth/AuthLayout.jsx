import { Link, Outlet } from 'react-router-dom'

import ThemeToggle from '../components/ThemeToggle.jsx'
import { useSiteName } from '../stores/options.js'

export default function AuthLayout() {
    const siteName = useSiteName()

    return (
        <div className="app-auth">
            <header className="app-auth-header">
                <Link to="/" className="app-brand">{siteName}</Link>

                <ThemeToggle />
            </header>

            <main className="app-auth-main">
                <div className="fe-card app-auth-card">
                    <div className="fe-card-body">
                        <Outlet />
                    </div>
                </div>
            </main>
        </div>
    )
}
