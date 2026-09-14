import '@testing-library/jest-dom/vitest'
import { cleanup } from '@testing-library/react'
import { afterEach, vi } from 'vitest'

// Iconify pide los iconos a su API al montarse: en jsdom sería red de verdad.
vi.mock('@iconify/react', () => ({ Icon: () => null }))

if (! window.matchMedia) {
    window.matchMedia = (query) => ({
        matches: false,
        media: query,
        onchange: null,
        addEventListener() {},
        removeEventListener() {},
        addListener() {},
        removeListener() {},
        dispatchEvent: () => false,
    })
}

// ScrollRestoration llama a scrollTo, que jsdom no implementa.
window.scrollTo = () => {}

afterEach(() => {
    cleanup()
})
