import { useSyncExternalStore } from 'react'
import { create } from 'zustand'

// La misma clave que lee el script de app.blade.php antes de pintar, y la
// misma que la interfaz en Vue.
export const THEME_STORAGE_KEY = 'theme'

const DARK_QUERY = '(prefers-color-scheme: dark)'

export function readStoredTheme(storage = globalThis.localStorage) {
    try {
        const value = storage?.getItem(THEME_STORAGE_KEY)

        return value === 'dark' || value === 'light' ? value : null
    } catch {
        return null
    }
}

function storeTheme(value, storage = globalThis.localStorage) {
    try {
        storage?.setItem(THEME_STORAGE_KEY, value)
    } catch {
        // Sin almacenamiento (modo privado) la elección dura lo que la pestaña.
    }
}

export const systemPrefersDark = () => globalThis.matchMedia?.(DARK_QUERY)?.matches === true

/** Sin elección guardada manda el sistema. */
export const effectiveTheme = (choice, prefersDark) => choice ?? (prefersDark ? 'dark' : 'light')

export function applyTheme(choice, root = document.documentElement) {
    if (choice) {
        root.dataset.theme = choice
    } else {
        delete root.dataset.theme
    }
}

export const useUiStore = create((set, get) => ({
    /** 'dark', 'light' o null, que es «lo que diga el sistema». */
    theme: null,
    sidebarOpen: false,

    initTheme: () => {
        const theme = readStoredTheme()

        applyTheme(theme)
        set({ theme })
    },

    toggleTheme: () => {
        const next = effectiveTheme(get().theme, systemPrefersDark()) === 'dark' ? 'light' : 'dark'

        storeTheme(next)
        applyTheme(next)
        set({ theme: next })
    },

    setSidebarOpen: (sidebarOpen) => set({ sidebarOpen }),
}))

const subscribeToSystem = (callback) => {
    const media = globalThis.matchMedia?.(DARK_QUERY)

    media?.addEventListener?.('change', callback)

    return () => media?.removeEventListener?.('change', callback)
}

export function useIsDark() {
    const theme = useUiStore((state) => state.theme)
    const prefersDark = useSyncExternalStore(subscribeToSystem, systemPrefersDark, () => false)

    return effectiveTheme(theme, prefersDark) === 'dark'
}
