export const CONSENT_COOKIE = 'cookie_consent'

export const CONSENT_DAYS = 365

export function readCookie(name, doc = document) {
    for (const part of String(doc.cookie ?? '').split(';')) {
        const [key, ...rest] = part.trim().split('=')

        if (key === name) {
            try {
                return decodeURIComponent(rest.join('='))
            } catch {
                return rest.join('=')
            }
        }
    }

    return null
}

export function readConsent(doc = document) {
    const value = readCookie(CONSENT_COOKIE, doc)

    return value === 'accepted' || value === 'rejected' ? value : null
}

export function writeConsent(value, doc = document, days = CONSENT_DAYS) {
    if (value !== 'accepted' && value !== 'rejected') {
        return
    }

    doc.cookie = `${CONSENT_COOKIE}=${value}; max-age=${days * 86400}; path=/; SameSite=Lax`
}
