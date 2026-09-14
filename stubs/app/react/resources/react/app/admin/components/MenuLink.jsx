import { NavLink } from 'react-router-dom'
import t from 'innoboxrr-i18n'
import { IconComponent } from 'innoboxrr-react-form-elements'

/**
 * Una entrada del menú: una pantalla de la SPA con NavLink, o una herramienta
 * de Laravel (log-viewer, env-editor) en otra pestaña.
 */
export default function MenuLink({ entry, className, iconClassName = 'app-nav-icon', onNavigate }) {
    const content = (
        <>
            <span className={iconClassName}><IconComponent name={entry.icon} size={18} /></span>
            <span className="app-nav-label">{entry.label}</span>
            {entry.external ? (
                <>
                    <IconComponent name="external" size={11} className="app-nav-external" />
                    <span className="app-sr-only">{t('(opens in a new tab)')}</span>
                </>
            ) : null}
        </>
    )

    if (entry.external) {
        return <a href={entry.href} className={className} target="_blank" rel="noopener noreferrer">{content}</a>
    }

    return <NavLink to={entry.to} end={entry.end === true} className={className} onClick={onNavigate}>{content}</NavLink>
}
