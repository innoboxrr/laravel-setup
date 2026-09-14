import axios from 'axios'
import route, { hasRoute } from 'innoboxrr-route-resolver'

/**
 * La única copia de axios de la aplicación. El módulo de LaraPack llega a ella
 * a través de innoboxrr-http-request, así que los interceptores de aquí también
 * cubren sus peticiones.
 */
export const http = axios

export function configureAxios(instance = axios) {
    instance.defaults.withCredentials = true
    // Desde axios 1.6 la cabecera X-XSRF-TOKEN no se envía sin esto, ni siquiera
    // al mismo origen.
    instance.defaults.withXSRFToken = true
    instance.defaults.headers.common.Accept = 'application/json'
    instance.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

    return instance
}

/**
 * La URL de una ruta del backend. Una ruta que no está en routes.json lanza:
 * con `undefined` axios pediría la página actual y el fallo sería silencioso.
 */
export function apiUrl(name, params) {
    if (! hasRoute(name)) {
        throw new Error(`Unknown backend route "${name}". Run php artisan route:json.`)
    }

    return params === undefined ? route(name) : route(name, params)
}

export function csrfCookieUrl() {
    return hasRoute('sanctum.csrf-cookie') ? route('sanctum.csrf-cookie') : '/sanctum/csrf-cookie'
}

export function requestCsrfCookie(instance = axios) {
    return instance.get(csrfCookieUrl(), { skipAuthHandling: true })
}

/**
 * Qué hacer con una respuesta de error, fuera de axios para poder probarlo.
 *
 * - 419: la sesión caducó y el token CSRF ya no vale. Se pide otra cookie y se
 *   repite la petición una sola vez.
 * - 401: la sesión se perdió. `skipAuthHandling` lo desactiva para las
 *   peticiones que ya esperan no tener sesión (cargarla, la cookie CSRF).
 */
export function createErrorHandler({ instance = axios, onUnauthorized = () => {} } = {}) {
    return async (error) => {
        const status = error?.response?.status
        const config = error?.config

        if (status === 419 && config && ! config.csrfRetried) {
            config.csrfRetried = true

            await requestCsrfCookie(instance)

            return instance.request(config)
        }

        if (status === 401 && ! config?.skipAuthHandling) {
            onUnauthorized(error)
        }

        return Promise.reject(error)
    }
}

export function installInterceptors({ instance = axios, onUnauthorized } = {}) {
    return instance.interceptors.response.use(
        (response) => response,
        createErrorHandler({ instance, onUnauthorized }),
    )
}

/**
 * El mensaje que se enseña cuando algo falla fuera de los campos.
 */
export function errorMessage(error, t) {
    const status = error?.response?.status
    const data = error?.response?.data

    if (! error?.response) {
        return t('Could not connect to the server.')
    }

    if (status === 429) {
        return t('Too many attempts. Try again in a moment.')
    }

    if (status === 403) {
        return data?.message && data.message !== 'This action is unauthorized.'
            ? data.message
            : t('You are not allowed to do this.')
    }

    if (typeof data?.message === 'string' && data.message !== '') {
        return data.message
    }

    return t('Something went wrong. Try again.')
}

/**
 * Los errores de validación de Laravel, `{campo: [mensajes]}`, o null.
 */
export function validationErrors(error) {
    const errors = error?.response?.status === 422 ? error.response.data?.errors : null

    return errors && typeof errors === 'object' ? errors : null
}
