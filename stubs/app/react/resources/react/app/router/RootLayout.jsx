import { useEffect } from 'react'
import { Outlet, ScrollRestoration, useMatches } from 'react-router-dom'

import { useSiteName } from '../stores/options.js'

/**
 * El título de la pestaña: `<título> · <nombre del sitio>`. Las páginas del
 * sitio lo ponen ellas, porque su título está en la opción `theme`.
 */
export default function RootLayout() {
    const matches = useMatches()
    const siteName = useSiteName()

    const isSitePage = Boolean(matches.at(-1)?.handle?.page)
    const title = [...matches].reverse().find((match) => match.handle?.title)?.handle.title ?? null

    useEffect(() => {
        if (! isSitePage) {
            document.title = title ? `${title} · ${siteName}` : siteName
        }
    }, [isSitePage, title, siteName])

    return (
        <>
            <Outlet />
            <ScrollRestoration />
        </>
    )
}
