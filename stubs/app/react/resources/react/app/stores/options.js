import axios from 'axios'
import { create } from 'zustand'
import route from 'innoboxrr-route-resolver'

// El título que puso Blade con config('app.name'), leído antes de que la
// aplicación lo cambie: es el nombre cuando la opción `site_name` falta.
const initialTitle = typeof document === 'undefined' ? '' : document.title

/**
 * Sólo se decodifican objetos y listas. Un `site_name` como "2025" también es
 * JSON válido, y convertirlo en número rompería quien lo trate como texto.
 */
export function decodeValue(value) {
    if (typeof value !== 'string') {
        return value
    }

    const trimmed = value.trim()

    if (! trimmed.startsWith('{') && ! trimmed.startsWith('[')) {
        return value
    }

    try {
        return JSON.parse(trimmed)
    } catch {
        return value
    }
}

export const encodeValue = (value) => (typeof value === 'string' ? value : JSON.stringify(value))

/**
 * `site_name`, o `theme.home.title`: la primera parte es la clave de la opción
 * y el resto entra en su JSON.
 */
export function readPath(values, path, fallback = null) {
    const key = String(path)

    if (Object.hasOwn(values ?? {}, key)) {
        return values[key] ?? fallback
    }

    const [first, ...rest] = key.split('.')
    let current = values?.[first]

    for (const segment of rest) {
        if (current === null || typeof current !== 'object') {
            return fallback
        }

        current = current[segment]
    }

    return current === undefined || current === null ? fallback : current
}

/**
 * @param {{ http?: any, resolve?: typeof route }} deps
 */
export function createOptionsStore({ http = axios, resolve = route } = {}) {
    return create((set, get) => ({
        values: {},
        records: {},
        loaded: false,

        load: async () => {
            try {
                const { data } = await http.get(resolve('api.laravel-options.option.index', { paginate: 0 }))

                get().hydrate(Array.isArray(data) ? data : (data?.data ?? []))
            } catch (error) {
                console.error('[options] The options could not be loaded.', error)

                set({ loaded: true })
            }

            return get().values
        },

        hydrate: (list = []) => {
            const values = {}
            const records = {}

            list.forEach((option) => {
                if (! option || typeof option.key !== 'string') {
                    return
                }

                values[option.key] = decodeValue(option.value)
                records[option.key] = { id: option.id ?? null, key: option.key, name: option.name ?? option.key }
            })

            set({ values, records, loaded: true })
        },

        option: (path, fallback = null) => readPath(get().values, path, fallback),

        /**
         * Guarda una opción. Sólo puede un administrador: la política de
         * laravel-options responde 403 a los demás.
         */
        save: async (key, value) => {
            const record = get().records[key]
            const serialized = encodeValue(value)

            // Una opción que la siembra no creó no tiene id que actualizar.
            const response = record?.id
                ? await http.put(resolve('api.laravel-options.option.update'), { option_id: record.id, name: record.name ?? key, key, value: serialized })
                : await http.post(resolve('api.laravel-options.option.create'), { key, name: key, value: serialized })

            const saved = response?.data?.data ?? response?.data ?? {}

            set((state) => ({
                values: { ...state.values, [key]: decodeValue(serialized) },
                records: {
                    ...state.records,
                    [key]: { id: saved.id ?? record?.id ?? null, key, name: saved.name ?? record?.name ?? key },
                },
            }))

            return saved
        },
    }))
}

export const useOptionsStore = createOptionsStore()

/**
 * Se lee `values` y se resuelve fuera del selector: un selector que devuelve
 * un objeto nuevo en cada lectura hace que Zustand repinte sin fin.
 */
export function useOption(path, fallback = null) {
    const values = useOptionsStore((state) => state.values)

    return readPath(values, path, fallback)
}

export function useSiteName() {
    const values = useOptionsStore((state) => state.values)
    const name = readPath(values, 'site_name', '')

    return typeof name === 'string' && name !== '' ? name : initialTitle
}
