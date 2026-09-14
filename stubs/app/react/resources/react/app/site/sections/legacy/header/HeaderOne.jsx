import { useEffect, useId, useState } from 'react'
import { Link, useLocation } from 'react-router-dom'
import t from 'innoboxrr-i18n'
import { IconComponent } from 'innoboxrr-react-form-elements'

import ThemeToggle from '../../../../components/ThemeToggle.jsx'
import { useAuthStore } from '../../../../stores/auth.js'
import { useSiteName } from '../../../../stores/options.js'
import { asArray, asText, Brand, SmartLink, SocialLinks } from '../../shared.jsx'

/**
 * @param {{ props: { logo?: string, nav?: Array<{label: string, link: string}>, facebook?: string, twitter?: string, instagram?: string, youtube?: string, whatsapp?: string, linkedin?: string, tiktok?: string } }} props
 */
export default function HeaderOne({ props = {} }) {
    const authenticated = useAuthStore((state) => state.authenticated)
    const siteName = useSiteName()
    const location = useLocation()
    const navId = useId()
    const [open, setOpen] = useState(false)

    const nav = asArray(props.nav).filter((item) => asText(item?.label) !== '')

    useEffect(() => setOpen(false), [location.pathname])

    return (
        <header className="site-header">
            <div className="site-container site-header-bar">
                <Brand logo={props.logo} name={siteName} />

                <button
                    type="button"
                    className="fe-icon-button site-nav-toggle"
                    aria-expanded={open}
                    aria-controls={navId}
                    aria-label={open ? t('Close menu') : t('Open menu')}
                    onClick={() => setOpen((value) => ! value)}>
                    <IconComponent name={open ? 'close' : 'menu'} size={18} />
                </button>

                <nav id={navId} className="site-nav" data-open={open ? 'true' : 'false'} aria-label={t('Site')}>
                    {nav.length > 0 ? (
                        <ul className="site-nav-list">
                            {nav.map((item, index) => (
                                <li key={`${index}-${item.label}`}>
                                    <SmartLink href={item.link} className="site-nav-link">{asText(item.label)}</SmartLink>
                                </li>
                            ))}
                        </ul>
                    ) : null}

                    <div className="site-nav-actions">
                        <SocialLinks links={props} />

                        <ThemeToggle />

                        <Link to={authenticated ? '/admin' : '/auth/login'} className="fe-button">
                            {authenticated ? t('Administrator') : t('Sign in')}
                        </Link>
                    </div>
                </nav>
            </div>
        </header>
    )
}
