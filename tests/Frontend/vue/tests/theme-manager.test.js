import { afterEach, describe, expect, it, vi } from 'vitest'
import { mount } from '@vue/test-utils'
import { createPinia } from 'pinia'
import { h, markRaw } from 'vue'
import { createMemoryHistory, createRouter } from 'vue-router'
import { buildRoutes } from '@app/router/index.js'
import ThemeManager from '@app/site/ThemeManager.vue'
import registry from '@app/site/sections/index.js'
import { isDisplayed, renderableSections, splitLandmarks } from '@app/site/render.js'
import fixture from '../../fixtures/options.json'

const fake = (name) => markRaw({
    name,
    inheritAttrs: false,
    props: ['title'],
    setup(props) {
        return () => h('section', { 'data-section': name }, props.title ?? '')
    },
})

const testRegistry = {
    'legacy/header/HeaderOne': fake('Header'),
    'legacy/hero/HeroOne': fake('Hero'),
    'legacy/section/FaqSection': fake('Faq'),
    'legacy/footer/FooterOne': fake('Footer'),
}

const section = (group, name, props) => ({ theme: 'legacy', group, name, ...(props === undefined ? {} : { props }) })

const order = (wrapper) => wrapper.findAll('[data-section]').map((node) => node.attributes('data-section'))

describe('ThemeManager', () => {
    afterEach(() => {
        vi.restoreAllMocks()
    })

    it('renders the sections in the order of the JSON, with their props', () => {
        const page = {
            title: 'Inicio',
            sections: [
                section('header', 'HeaderOne', { title: 'cabecera' }),
                section('section', 'FaqSection', { title: 'preguntas' }),
                section('hero', 'HeroOne', { title: 'héroe' }),
                section('section', 'FaqSection', { title: 'otra vez' }),
                section('footer', 'FooterOne', {}),
            ],
        }

        const wrapper = mount(ThemeManager, { props: { page, registry: testRegistry } })

        expect(order(wrapper)).toEqual(['Header', 'Faq', 'Hero', 'Faq', 'Footer'])
        expect(wrapper.findAll('[data-section="Faq"]').map((node) => node.text())).toEqual(['preguntas', 'otra vez'])

        // La cabecera y el pie quedan fuera del contenido principal.
        expect(wrapper.find('main [data-section="Header"]').exists()).toBe(false)
        expect(wrapper.find('main [data-section="Hero"]').exists()).toBe(true)
        expect(wrapper.find('main [data-section="Footer"]').exists()).toBe(false)
    })

    it('skips sections with display false or "false" and keeps those without the key', () => {
        const page = {
            sections: [
                section('hero', 'HeroOne', { display: false, title: 'a' }),
                section('hero', 'HeroOne', { display: 'false', title: 'b' }),
                section('hero', 'HeroOne', { display: true, title: 'c' }),
                section('hero', 'HeroOne', { display: 'true', title: 'd' }),
                section('hero', 'HeroOne', { title: 'e' }),
                section('hero', 'HeroOne'),
            ],
        }

        const wrapper = mount(ThemeManager, { props: { page, registry: testRegistry } })

        expect(wrapper.findAll('[data-section="Hero"]').map((node) => node.text())).toEqual(['c', 'd', 'e', ''])
    })

    it('skips an unknown section and warns about it', () => {
        const warn = vi.spyOn(console, 'warn').mockImplementation(() => {})
        const page = {
            sections: [
                section('hero', 'HeroOne', { title: 'uno' }),
                section('section', 'CarouselSection', { title: 'no existe' }),
                { theme: 'preline', group: 'hero', name: 'HeroOne', props: {} },
                null,
                'basura',
                section('section', 'FaqSection', { title: 'dos' }),
            ],
        }

        const wrapper = mount(ThemeManager, { props: { page, registry: testRegistry } })

        expect(order(wrapper)).toEqual(['Hero', 'Faq'])
        expect(warn).toHaveBeenCalledWith(expect.stringContaining('legacy/section/CarouselSection'))
        expect(warn).toHaveBeenCalledWith(expect.stringContaining('preline/hero/HeroOne'))
    })

    it('renders nothing but the frame for a page without sections', () => {
        const wrapper = mount(ThemeManager, { props: { page: { title: 'Vacía' }, registry: testRegistry } })

        expect(order(wrapper)).toEqual([])
        expect(wrapper.find('main').exists()).toBe(true)
    })

    it('renders the seeded home page with the real registry', () => {
        const theme = JSON.parse(fixture.find((option) => option.key === 'theme').value)
        const router = createRouter({ history: createMemoryHistory(), routes: buildRoutes([]) })
        const warn = vi.spyOn(console, 'warn').mockImplementation(() => {})
        const error = vi.spyOn(console, 'error').mockImplementation(() => {})

        const wrapper = mount(ThemeManager, {
            props: { page: theme.home },
            global: { plugins: [createPinia(), router] },
        })

        // El límite de errores de ThemeManager no puede estar ocultando nada.
        expect(error).not.toHaveBeenCalled()
        expect(warn).not.toHaveBeenCalledWith(expect.stringContaining('[site]'))
        expect(wrapper.find('.site-header-cta').attributes('href')).toBe('/auth/login')
        expect(wrapper.find('header.site-header').exists()).toBe(true)
        expect(wrapper.find('footer.site-footer').exists()).toBe(true)
        // PartnersSection viene con display false en la siembra.
        expect(wrapper.find('.site-partners').exists()).toBe(false)
        expect(wrapper.text()).toContain('Tu aplicación, lista para crecer')
    })
})

describe('render helpers', () => {
    it('knows every section of the contract', () => {
        expect(Object.keys(registry).sort()).toEqual([
            'legacy/cookie-consent/CookieConsentOne',
            'legacy/footer/FooterOne',
            'legacy/header/HeaderOne',
            'legacy/hero/HeroOne',
            'legacy/hero/HeroThree',
            'legacy/hero/HeroTwo',
            'legacy/section/FaqSection',
            'legacy/section/HtmlContent',
            'legacy/section/JoinSection',
            'legacy/section/MissionSection',
            'legacy/section/PartnersSection',
            'legacy/section/PlansSection',
            'legacy/section/TestimonialsSection',
        ])
    })

    it('treats only false and "false" as hidden', () => {
        expect(isDisplayed({ display: false })).toBe(false)
        expect(isDisplayed({ display: 'false' })).toBe(false)
        expect(isDisplayed({ display: 0 })).toBe(true)
        expect(isDisplayed({})).toBe(true)
        expect(isDisplayed(undefined)).toBe(true)
    })

    it('gives a section with broken props an empty object', () => {
        const [item] = renderableSections({ sections: [section('hero', 'HeroOne', ['no', 'es', 'objeto'])] }, testRegistry, () => {})

        expect(item.props).toEqual({})
    })

    it('keeps the order when splitting the landmarks', () => {
        const items = ['header', 'hero', 'header', 'footer', 'cookie-consent'].map((group, index) => ({ group, key: String(index) }))
        const { before, main, after } = splitLandmarks(items)

        expect([...before, ...main, ...after].map((item) => item.key)).toEqual(['0', '1', '2', '3', '4'])
        expect(main.map((item) => item.group)).toEqual(['hero', 'header'])
    })
})
