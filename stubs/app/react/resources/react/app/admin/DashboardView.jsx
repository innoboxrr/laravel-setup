import { useOutletContext } from 'react-router-dom'
import t from 'innoboxrr-i18n'

import { useAuthStore } from '../stores/auth.js'
import MenuLink from './components/MenuLink.jsx'

export default function DashboardView() {
    const { menu } = useOutletContext() ?? { menu: { main: [], admin: [] } }
    const user = useAuthStore((state) => state.user)

    const cards = [...menu.main.filter((entry) => entry.id !== 'admin.dashboard'), ...menu.admin]

    return (
        <div className="app-page">
            <header className="app-page-header">
                <div>
                    <h1 className="app-page-title">{user?.name ? t('Hello, :name', { name: user.name }) : t('Hello')}</h1>
                    <p className="app-page-subtitle">{t('What would you like to do today?')}</p>
                </div>
            </header>

            {cards.length > 0 ? (
                <ul className="app-cards">
                    {cards.map((entry) => (
                        <li key={entry.id}>
                            <MenuLink entry={entry} className="fe-card app-card" iconClassName="app-card-icon" />
                        </li>
                    ))}
                </ul>
            ) : (
                <p className="fe-text-muted">{t('There is nothing here yet. Generate a model with LaraPack and it will appear in the menu.')}</p>
            )}
        </div>
    )
}
