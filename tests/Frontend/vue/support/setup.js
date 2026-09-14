import { afterEach, vi } from 'vitest'

// Iconify pide los iconos a su API por red: en las pruebas, un <svg> con el
// nombre basta para saber qué icono se pidió.
vi.mock('@iconify/vue', async () => {
    const { h } = await import('vue')

    return {
        Icon: {
            name: 'IconifyIcon',
            props: ['icon', 'width', 'height'],
            render() {
                return h('svg', { 'data-icon': this.icon })
            },
        },
    }
})

// Floating UI mide el DOM y jsdom no tiene medidas: con la librería real el
// MenuComponent se queda colgado.
vi.mock('@floating-ui/dom', () => ({
    autoUpdate: vi.fn((reference, floating, update) => {
        update()

        return () => {}
    }),
    computePosition: vi.fn(() => Promise.resolve({ x: 0, y: 0 })),
    flip: vi.fn(),
    offset: vi.fn(),
    shift: vi.fn(),
}))

if (typeof window.matchMedia !== 'function') {
    window.matchMedia = (query) => ({
        matches: false,
        media: query,
        addEventListener() {},
        removeEventListener() {},
    })
}

afterEach(() => {
    document.cookie.split(';').forEach((part) => {
        const name = part.split('=')[0].trim()

        if (name) {
            document.cookie = `${name}=; max-age=0; path=/`
        }
    })
})
