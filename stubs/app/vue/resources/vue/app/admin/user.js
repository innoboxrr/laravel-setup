/**
 * Lo que las pantallas leen del usuario de la sesión. `payload` lo rehace el
 * backend desde las metas (el avatar es una de ellas) y puede llegar como
 * objeto o, sin el cast, como texto JSON.
 */

export function userPayload(user) {
    const payload = user?.payload

    if (typeof payload === 'string') {
        try {
            const decoded = JSON.parse(payload)

            return decoded && typeof decoded === 'object' ? decoded : {}
        } catch {
            return {}
        }
    }

    return payload && typeof payload === 'object' ? payload : {}
}

export function avatarOf(user) {
    const avatar = userPayload(user).avatar

    return typeof avatar === 'string' && avatar.trim() !== '' ? avatar : null
}

export function initialsOf(user) {
    const source = typeof user?.name === 'string' && user.name.trim() !== '' ? user.name : String(user?.email ?? '')

    return source.trim().split(/\s+/).filter(Boolean).slice(0, 2).map((part) => part[0].toUpperCase()).join('')
}

export function firstNameOf(user) {
    const name = typeof user?.name === 'string' ? user.name.trim() : ''

    return name === '' ? '' : name.split(/\s+/)[0]
}
