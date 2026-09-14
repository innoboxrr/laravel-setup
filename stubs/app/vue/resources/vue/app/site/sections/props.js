/**
 * Las props de una sección vienen de un JSON que escribe una persona: pueden
 * faltar o tener otro tipo. Estas funciones las dejan en la forma que la
 * plantilla espera, para que una sección nunca lance por un dato raro.
 */

export const asArray = (value) => (Array.isArray(value) ? value : [])

export const asObject = (value) => (value !== null && typeof value === 'object' && ! Array.isArray(value) ? value : {})

export const asText = (value) => {
    if (typeof value === 'string') {
        return value
    }

    return typeof value === 'number' && Number.isFinite(value) ? String(value) : ''
}

export const filled = (value) => asText(value).trim() !== ''

export const isTruthy = (value) => value === true || value === 'true' || value === 1 || value === '1'

export const imageUrl = (value) => (filled(value) ? asText(value).trim() : null)

export const imageList = (value, max = Infinity) => asArray(value).map(imageUrl).filter(Boolean).slice(0, max)

export const textList = (value) => asArray(value).map(asText).filter((item) => item.trim() !== '')

export const initials = (name) => asText(name)
    .trim()
    .split(/\s+/)
    .filter(Boolean)
    .slice(0, 2)
    .map((part) => part[0].toUpperCase())
    .join('')
