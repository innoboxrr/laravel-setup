import { ref } from 'vue'
import { defineStore } from 'pinia'
import { apiUrl, http } from '@app/http.js'

export const OPTION_ROUTES = {
    index: 'api.laravel-options.option.index',
    create: 'api.laravel-options.option.create',
    update: 'api.laravel-options.option.update',
}

const isPlainObject = (value) => value !== null && typeof value === 'object' && ! Array.isArray(value)

/**
 * Sólo se decodifica un objeto o un arreglo JSON, igual que Option::value() en
 * el backend: un nombre de sitio "2024" o "true" sigue siendo texto.
 */
export function decodeValue(value) {
    if (typeof value !== 'string') {
        return value
    }

    const trimmed = value.trim()

    if (! (trimmed.startsWith('{') || trimmed.startsWith('['))) {
        return value
    }

    try {
        return JSON.parse(trimmed)
    } catch {
        return value
    }
}

export function serializeValue(value) {
    if (value === null || value === undefined) {
        return null
    }

    return typeof value === 'string' ? value : JSON.stringify(value)
}

/**
 * La lista del index (`[{id, key, name, value}]`, con o sin envoltorio `data`)
 * como dos mapas por clave: los valores ya decodificados y lo necesario para
 * actualizar cada opción.
 */
export function decodeOptions(payload) {
    const list = Array.isArray(payload) ? payload : (Array.isArray(payload?.data) ? payload.data : [])
    const values = {}
    const records = {}

    for (const item of list) {
        if (! item || typeof item.key !== 'string') {
            continue
        }

        values[item.key] = decodeValue(item.value)
        records[item.key] = { id: item.id ?? null, name: item.name ?? item.key }
    }

    return { values, records }
}

/**
 * `site_name` o `theme.home.title`: primero la clave entera y, si no existe,
 * la primera parte es la opción y el resto el camino dentro de su JSON.
 */
export function readOption(values, path, fallback = undefined) {
    if (typeof path !== 'string' || path === '') {
        return fallback
    }

    if (Object.hasOwn(values, path)) {
        return values[path] ?? fallback
    }

    const [key, ...rest] = path.split('.')

    if (! Object.hasOwn(values, key)) {
        return fallback
    }

    let current = values[key]

    for (const segment of rest) {
        if (current === null || typeof current !== 'object' || ! Object.hasOwn(current, segment)) {
            return fallback
        }

        current = current[segment]
    }

    return current ?? fallback
}

/**
 * La petición que guarda una opción: el update de laravel-options si ya
 * existe, y el create si todavía no.
 */
export function buildSaveRequest(key, value, record = null) {
    const serialized = serializeValue(value)

    if (record?.id) {
        return {
            method: 'put',
            route: OPTION_ROUTES.update,
            data: { option_id: record.id, value: serialized },
        }
    }

    return {
        method: 'post',
        route: OPTION_ROUTES.create,
        data: { key, name: record?.name ?? key, value: serialized },
    }
}

export const useOptionsStore = defineStore('app.options', () => {
    const values = ref({})
    const records = ref({})
    const loaded = ref(false)

    const load = async () => {
        try {
            const response = await http.get(apiUrl(OPTION_ROUTES.index, { paginate: 0 }))
            const decoded = decodeOptions(response.data)

            values.value = decoded.values
            records.value = decoded.records
        } finally {
            loaded.value = true
        }

        return values.value
    }

    const option = (path, fallback = undefined) => readOption(values.value, path, fallback)

    const save = async (key, value) => {
        const request = buildSaveRequest(key, value, records.value[key])
        const response = await http[request.method](apiUrl(request.route), request.data)
        const saved = response.data ?? {}

        records.value = {
            ...records.value,
            [key]: { id: saved.id ?? records.value[key]?.id ?? null, name: saved.name ?? request.data.name ?? records.value[key]?.name ?? key },
        }

        // Se guarda lo que se envió, decodificado igual que al cargar: una copia,
        // para que editar el borrador después no cambie el estado.
        values.value = { ...values.value, [key]: decodeValue(request.data.value) }

        return saved
    }

    return { values, records, loaded, load, option, save }
})

export { isPlainObject }
