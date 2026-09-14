import axios from 'axios'
import { create } from 'zustand'
import route from 'innoboxrr-route-resolver'

import { userUpdateRoute } from '../config.js'
import { csrfCookieUrl } from '../http.js'

const signedOut = {
    user: null,
    authenticated: false,
    is_admin: false,
    verified: false,
    impersonating: false,
}

/**
 * `payload` lo rehace el backend desde las metas; sin el cast `array` llega
 * como texto JSON.
 */
export function payloadOf(user) {
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

export const avatarOf = (user) => {
    const avatar = payloadOf(user).avatar

    return typeof avatar === 'string' && avatar.trim() !== '' ? avatar : null
}

/**
 * La sesión, con las rutas de laravel-auth 6. Las dependencias se inyectan
 * para poder probarla sin red.
 *
 * @param {{ http?: any, resolve?: typeof route, csrfUrl?: () => string }} deps
 */
export function createAuthStore({ http = axios, resolve = route, csrfUrl = csrfCookieUrl } = {}) {
    return create((set, get) => {
        // Entrar y registrarse regeneran la sesión en Laravel: la cookie
        // XSRF-TOKEN tiene que existir antes del POST.
        const csrf = () => http.get(csrfUrl())

        return {
            ...signedOut,
            loaded: false,

            load: async () => {
                try {
                    const { data } = await http.get(resolve('auth.get.auth'), { skipAuthRedirect: true })

                    set({
                        user: data?.user ?? null,
                        authenticated: data?.authenticated === true,
                        is_admin: data?.is_admin === true,
                        verified: data?.verified === true,
                        impersonating: data?.impersonating === true,
                        loaded: true,
                    })
                } catch (error) {
                    // Sin respuesta se sigue como visitante: el sitio público
                    // no depende de la sesión.
                    console.error('[auth] The session could not be loaded.', error)

                    set({ ...signedOut, loaded: true })
                }

                return get()
            },

            login: async ({ email, password, remember = false }) => {
                await csrf()

                const { data } = await http.post(resolve('auth.login'), { email, password, remember })

                await get().load()

                return data
            },

            register: async ({ name, email, password, password_confirmation }) => {
                await csrf()

                const { data } = await http.post(resolve('auth.register'), { name, email, password, password_confirmation })

                await get().load()

                return data
            },

            logout: async () => {
                try {
                    await http.post(resolve('auth.logout'), {}, { skipAuthRedirect: true })
                } finally {
                    get().clear()
                }
            },

            forgotPassword: async ({ email }) => {
                await csrf()

                return (await http.post(resolve('auth.forgot.password'), { email })).data
            },

            resetPassword: async ({ token, email, password, password_confirmation }) => {
                await csrf()

                return (await http.post(resolve('auth.reset.password'), { token, email, password, password_confirmation })).data
            },

            updatePassword: async ({ old_password, password, password_confirmation }) => {
                return (await http.post(resolve('auth.update.password'), { old_password, password, password_confirmation })).data
            },

            resendVerification: async () => {
                return (await http.post(resolve('auth.email.verification.notification'))).data
            },

            revertImpersonation: async () => {
                const { data } = await http.get(resolve('auth.revert.impersonate'))

                await get().load()

                return data
            },

            updateProfile: async ({ name, email }) => {
                const { data } = await http.put(resolve(userUpdateRoute), { user_id: get().user?.id, name, email })

                await get().load()

                return data
            },

            /**
             * La imagen se sube a laravel-uploads y se guarda como la meta
             * `avatar` del usuario, con el mismo update del perfil. Se guarda
             * el `uri` relativo y no la `url`: sigue valiendo si cambia el
             * dominio.
             */
            updateAvatar: async (file) => {
                const body = new FormData()

                body.append('file', file)
                body.append('visibility', 'public')

                const { data } = await http.post(resolve('lu.upload.file'), body)
                const upload = data?.data ?? data
                const location = upload?.uri ?? upload?.url

                if (! location) {
                    throw new Error('The upload did not return a location.')
                }

                await http.put(resolve(userUpdateRoute), { user_id: get().user?.id, avatar: location })
                await get().load()

                return location
            },

            // Una meta vacía se borra.
            removeAvatar: async () => {
                await http.put(resolve(userUpdateRoute), { user_id: get().user?.id, avatar: '' })
                await get().load()
            },

            clear: () => set({ ...signedOut, loaded: true }),
        }
    })
}

export const useAuthStore = createAuthStore()
