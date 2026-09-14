import { computed, ref } from 'vue'
import { defineStore } from 'pinia'
import { apiUrl, http, requestCsrfCookie } from '@app/http.js'

/**
 * Los nombres de las rutas de laravel-auth, tal como los define su
 * config/laravel-auth.php (prefijo `auth.` y `routes.names`).
 */
export const AUTH_ROUTES = {
    getAuth: 'auth.get.auth',
    login: 'auth.login',
    register: 'auth.register',
    logout: 'auth.logout',
    forgotPassword: 'auth.forgot.password',
    resetPassword: 'auth.reset.password',
    updatePassword: 'auth.update.password',
    resendVerification: 'auth.email.verification.notification',
    revertImpersonation: 'auth.revert.impersonate',
}

export const emptySession = () => ({
    user: null,
    authenticated: false,
    is_admin: false,
    verified: false,
    impersonating: false,
})

/**
 * La respuesta de get-auth, con cada campo en su tipo aunque falte.
 */
export function normalizeSession(data) {
    const user = data?.user && typeof data.user === 'object' ? data.user : null
    const authenticated = user !== null && data?.authenticated !== false

    return {
        user: authenticated ? user : null,
        authenticated,
        is_admin: authenticated && data?.is_admin === true,
        verified: authenticated && data?.verified === true,
        impersonating: authenticated && data?.impersonating === true,
    }
}

export const useAuthStore = defineStore('app.auth', () => {
    const session = ref(emptySession())
    const loaded = ref(false)

    const user = computed(() => session.value.user)
    const authenticated = computed(() => session.value.authenticated)
    const isAdmin = computed(() => session.value.is_admin)
    const verified = computed(() => session.value.verified)
    const impersonating = computed(() => session.value.impersonating)

    const clear = () => {
        session.value = emptySession()
    }

    const load = async () => {
        try {
            const response = await http.get(apiUrl(AUTH_ROUTES.getAuth), { skipAuthHandling: true })

            session.value = normalizeSession(response.data)
        } catch {
            clear()
        } finally {
            loaded.value = true
        }

        return session.value
    }

    const setUser = (next) => {
        if (next && typeof next === 'object' && session.value.user) {
            session.value = { ...session.value, user: { ...session.value.user, ...next } }
        }
    }

    // Laravel regenera la sesión al entrar: la cookie CSRF se pide antes para
    // que el POST no responda 419.
    const login = async ({ email, password, remember = false }) => {
        await requestCsrfCookie(http)
        await http.post(apiUrl(AUTH_ROUTES.login), { email, password, remember: Boolean(remember) })

        return load()
    }

    const register = async (data) => {
        await requestCsrfCookie(http)
        await http.post(apiUrl(AUTH_ROUTES.register), data)

        return load()
    }

    const logout = async () => {
        try {
            await http.post(apiUrl(AUTH_ROUTES.logout), {}, { skipAuthHandling: true })
        } finally {
            clear()
        }
    }

    const forgotPassword = async ({ email }) => {
        const response = await http.post(apiUrl(AUTH_ROUTES.forgotPassword), { email })

        return response.data
    }

    const resetPassword = async ({ token, email, password, password_confirmation }) => {
        const response = await http.post(apiUrl(AUTH_ROUTES.resetPassword), { token, email, password, password_confirmation })

        return response.data
    }

    const updatePassword = async ({ old_password, password, password_confirmation }) => {
        const response = await http.post(apiUrl(AUTH_ROUTES.updatePassword), { old_password, password, password_confirmation })

        return response.data
    }

    const resendVerification = async () => {
        const response = await http.post(apiUrl(AUTH_ROUTES.resendVerification))

        return response.data
    }

    // Vuelve a la cuenta propia. Si la suplantación caducó el backend cierra la
    // sesión, y load() lo refleja.
    const revertImpersonation = async () => {
        await http.get(apiUrl(AUTH_ROUTES.revertImpersonation))

        return load()
    }

    return {
        session,
        loaded,
        user,
        authenticated,
        isAdmin,
        verified,
        impersonating,
        clear,
        load,
        setUser,
        login,
        register,
        logout,
        forgotPassword,
        resetPassword,
        updatePassword,
        resendVerification,
        revertImpersonation,
    }
})
