import { useState } from 'react'
import t from 'innoboxrr-i18n'

import { asText, SmartLink } from '../../shared.jsx'

export const CONSENT_COOKIE = 'cookie_consent'

export function readConsent(cookies = document.cookie) {
    const value = cookies
        .split(';')
        .map((part) => part.trim())
        .find((part) => part.startsWith(`${CONSENT_COOKIE}=`))
        ?.slice(CONSENT_COOKIE.length + 1)

    return value === 'accepted' || value === 'rejected' ? value : null
}

function writeConsent(value) {
    document.cookie = `${CONSENT_COOKIE}=${value}; max-age=${60 * 60 * 24 * 365}; path=/; SameSite=Lax`
}

/**
 * Guarda la decisión en la cookie `cookie_consent` y no vuelve a salir.
 *
 * @param {{ props: { message?: string, accept_text?: string, reject_text?: string, policy_link?: string } }} props
 */
export default function CookieConsentOne({ props = {} }) {
    const [decided, setDecided] = useState(() => readConsent() !== null)

    if (decided) {
        return null
    }

    const decide = (value) => {
        writeConsent(value)
        setDecided(true)
    }

    return (
        <div className="site-cookie" role="region" aria-label={t('Cookie consent')}>
            <p>
                {asText(props.message) || t('We use cookies to make the site work and to remember your preferences.')}

                {asText(props.policy_link) !== '' ? (
                    <>
                        {' '}
                        <SmartLink href={props.policy_link}>{t('Learn more')}</SmartLink>
                    </>
                ) : null}
            </p>

            <div className="site-actions">
                <button type="button" className="fe-button" onClick={() => decide('accepted')}>
                    {asText(props.accept_text) || t('Accept')}
                </button>

                <button type="button" className="fe-button-secondary" onClick={() => decide('rejected')}>
                    {asText(props.reject_text) || t('Reject')}
                </button>
            </div>
        </div>
    )
}
