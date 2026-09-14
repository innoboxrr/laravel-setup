import axios from 'axios'
import route, { hasRoute } from 'innoboxrr-route-resolver'

import { loginPath } from './router/guards.js'

/**
 * La cookie CSRF de Sanctum. Su ruta tiene nombre y llega en routes.json; la
 * URL escrita sólo cubre un routes.json que todavía no la trae.
 */
export const csrfCookieUrl = () => (hasRoute('sanctum.csrf-cookie') ? route('sanctum.csrf-cookie') : '/sanctum/csrf-cookie')

/**
 * @param {import('axios').AxiosStatic} http
 */
export function configureHttp(http = axios) {
    http.defaults.withCredentials = true
    http.defaults.withXSRFToken = true
    http.defaults.headers.common.Accept = 'application/json'
    http.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

    return http
}

/**
 * Lo que hace la aplicación con una respuesta fallida, de cualquier petición:
 * las del módulo de LaraPack pasan por la misma copia de axios.
 *
 * - 419: la sesión caducó con la pestaña abierta. Se pide otra cookie y se
 *   repite la petición una vez; una segunda vez sería un bucle.
 * - 401: se limpia la sesión y se va al login, salvo en las peticiones marcadas
 *   con `skipAuthRedirect` (la carga de la sesión, el logout), que ya saben qué
 *   hacer sin sesión.
 *
 * @param {{ http: Function, onUnauthenticated?: Function, csrfUrl?: () => string }} options
 */
export function createErrorHandler({ http, onUnauthenticated, csrfUrl = csrfCookieUrl }) {
    return async (error) => {
        const status = error?.response?.status
        const config = error?.config

        if (status === 419 && config && ! config.csrfRetried) {
            await http.get(csrfUrl())

            return http({ ...config, csrfRetried: true })
        }

        if (status === 401 && ! config?.skipAuthRedirect) {
            onUnauthenticated?.(error)
        }

        return Promise.reject(error)
    }
}

export function installInterceptors(http, options = {}) {
    return http.interceptors.response.use((response) => response, createErrorHandler({ http, ...options }))
}

/**
 * @param {{ clearSession: () => void, navigate: (to: string) => void, currentPath: () => string }} options
 */
export function unauthenticatedHandler({ clearSession, navigate, currentPath }) {
    return () => {
        clearSession()

        const path = currentPath()

        // Ya en una pantalla de acceso, llevar al login otra vez sólo perdería
        // lo que se estuviera escribiendo.
        if (! path.startsWith('/auth/')) {
            navigate(loginPath(path))
        }
    }
}
