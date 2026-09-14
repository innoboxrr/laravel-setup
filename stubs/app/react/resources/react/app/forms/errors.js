import t from 'innoboxrr-i18n'

/**
 * El mensaje que se enseña cuando algo falla: el primer error de validación,
 * el `message` de Laravel o uno genérico.
 */
export function errorMessage(error, fallback = null) {
    const status = error?.response?.status
    const data = error?.response?.data

    if (error && ! error.response) {
        return error.request ? t('Could not connect to the server.') : (fallback ?? t('Something went wrong. Try again.'))
    }

    if (status === 429) {
        return t('Too many attempts. Try again in a moment.')
    }

    // El texto por omisión de Laravel no dice nada útil a quien lo lee.
    if (status === 403) {
        return data?.message && data.message !== 'This action is unauthorized.'
            ? data.message
            : t('You are not allowed to do this.')
    }

    if (data?.errors && typeof data.errors === 'object') {
        const first = Object.values(data.errors).flat()[0]

        if (first) {
            return String(first)
        }
    }

    if (typeof data?.message === 'string' && data.message !== '') {
        return data.message
    }

    return fallback ?? t('Something went wrong. Try again.')
}
