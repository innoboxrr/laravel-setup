import t from 'innoboxrr-i18n'

import MenuLink from './MenuLink.jsx'

export default function SidebarMenu({ menu, onNavigate }) {
    return (
        <>
            <ul className="app-nav">
                {menu.main.map((entry) => (
                    <li key={entry.id}>
                        <MenuLink entry={entry} className="app-nav-link" onNavigate={onNavigate} />
                    </li>
                ))}
            </ul>

            {menu.admin.length > 0 ? (
                <div role="group" aria-labelledby="app-nav-admin">
                    <h2 id="app-nav-admin" className="app-nav-heading">{t('Administration')}</h2>

                    <ul className="app-nav">
                        {menu.admin.map((entry) => (
                            <li key={entry.id}>
                                <MenuLink entry={entry} className="app-nav-link" onNavigate={onNavigate} />
                            </li>
                        ))}
                    </ul>
                </div>
            ) : null}
        </>
    )
}
