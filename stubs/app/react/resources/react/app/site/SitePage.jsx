import { useEffect } from 'react'
import { Link } from 'react-router-dom'
import t from 'innoboxrr-i18n'

import { readPath, useOptionsStore, useSiteName } from '../stores/options.js'
import ThemeManager from './ThemeManager.jsx'

import '../styles/site.css'

/**
 * Una página del sitio, pintada desde la opción `theme`.
 */
export default function SitePage({ page }) {
    const values = useOptionsStore((state) => state.values)
    const siteName = useSiteName()

    const data = readPath(values, `theme.${page}`, null)
    const exists = data !== null && typeof data === 'object' && ! Array.isArray(data)
    const title = exists && typeof data.title === 'string' ? data.title : ''

    useEffect(() => {
        document.title = title !== '' ? `${title} · ${siteName}` : siteName
    }, [title, siteName])

    if (! exists) {
        return (
            <main className="site site-empty">
                <h1 className="site-heading">{t('This page has no content yet')}</h1>

                <p className="site-lead">{t('An administrator can add it from the site editor.')}</p>

                <div className="site-actions">
                    <Link to="/" className="fe-button site-button-lg">{t('Go to the home page')}</Link>
                </div>
            </main>
        )
    }

    return (
        <div className="site">
            <ThemeManager sections={data.sections} />
        </div>
    )
}
