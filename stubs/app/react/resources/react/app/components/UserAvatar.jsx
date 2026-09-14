import { useEffect, useState } from 'react'

import { avatarOf } from '../stores/auth.js'

export const initialsOf = (name) => String(name ?? '')
    .split(/\s+/)
    .filter(Boolean)
    .slice(0, 2)
    .map((word) => word[0].toUpperCase())
    .join('')

/**
 * La foto del usuario, o sus iniciales si no tiene o si la imagen no carga:
 * nunca un icono de imagen rota.
 */
export default function UserAvatar({ user, size = 'sm', alt = '' }) {
    const src = avatarOf(user)
    const [broken, setBroken] = useState(false)

    useEffect(() => setBroken(false), [src])

    return (
        <span className="app-avatar" data-size={size} aria-hidden={alt === '' ? 'true' : undefined}>
            {src && ! broken
                ? <img src={src} alt={alt} onError={() => setBroken(true)} />
                : <span>{initialsOf(user?.name) || '?'}</span>}
        </span>
    )
}
