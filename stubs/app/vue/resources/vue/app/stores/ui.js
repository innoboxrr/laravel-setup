import { computed, ref } from 'vue'
import { defineStore } from 'pinia'

export const THEME_KEY = 'theme'

export function readStoredTheme(storage = globalThis.localStorage) {
    try {
        const value = storage?.getItem(THEME_KEY)

        return value === 'dark' || value === 'light' ? value : null
    } catch {
        return null
    }
}

export function writeStoredTheme(value, storage = globalThis.localStorage) {
    try {
        if (value) {
            storage?.setItem(THEME_KEY, value)
        } else {
            storage?.removeItem(THEME_KEY)
        }
    } catch {
        // Sin almacenamiento (modo privado estricto) la elección dura la visita.
    }
}

const darkQuery = () => globalThis.matchMedia?.('(prefers-color-scheme: dark)') ?? null

/**
 * Sin elección no se escribe `data-theme`: form-core ya sigue al sistema con
 * prefers-color-scheme.
 */
export function applyTheme(choice, root = globalThis.document?.documentElement) {
    if (! root) {
        return
    }

    if (choice === 'dark' || choice === 'light') {
        root.dataset.theme = choice
    } else {
        delete root.dataset.theme
    }
}

export function effectiveTheme(choice, prefersDark) {
    return choice ?? (prefersDark ? 'dark' : 'light')
}

export const useUiStore = defineStore('app.ui', () => {
    const themeChoice = ref(readStoredTheme())
    const prefersDark = ref(Boolean(darkQuery()?.matches))
    const sidebarOpen = ref(false)

    const theme = computed(() => effectiveTheme(themeChoice.value, prefersDark.value))
    const isDark = computed(() => theme.value === 'dark')

    const init = () => {
        applyTheme(themeChoice.value)

        darkQuery()?.addEventListener?.('change', (event) => {
            prefersDark.value = event.matches
        })
    }

    const toggleTheme = () => {
        themeChoice.value = isDark.value ? 'light' : 'dark'

        writeStoredTheme(themeChoice.value)
        applyTheme(themeChoice.value)
    }

    const openSidebar = () => { sidebarOpen.value = true }
    const closeSidebar = () => { sidebarOpen.value = false }
    const toggleSidebar = () => { sidebarOpen.value = ! sidebarOpen.value }

    return { themeChoice, theme, isDark, sidebarOpen, init, toggleTheme, openSidebar, closeSidebar, toggleSidebar }
})
