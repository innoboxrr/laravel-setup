import { beforeEach, describe, expect, it } from 'vitest'
import { flushPromises, mount } from '@vue/test-utils'
import { createPinia, setActivePinia } from 'pinia'
import { createMemoryHistory, createRouter } from 'vue-router'
import registry from '@app/site/sections/index.js'
import { useAuthStore } from '@app/stores/auth.js'
import { useOptionsStore } from '@app/stores/options.js'
import { CONSENT_COOKIE, readConsent } from '@app/site/cookies.js'
import fixture from '../../fixtures/options.json'

const theme = JSON.parse(fixture.find((option) => option.key === 'theme').value)

/**
 * Las props de cada sección tal como las siembra SiteOptionsSeeder: la primera
 * vez que aparece en alguna página.
 */
const seeded = {}

for (const page of Object.values(theme)) {
    for (const section of page.sections) {
        const key = `${section.theme}/${section.group}/${section.name}`

        seeded[key] ??= section.props
    }
}

// HeroTwo y HeroThree no están en la siembra: parten de HeroOne, como dice el
// contrato, y HeroTwo añade lo suyo.
const { videos, ...heroWithoutVideos } = seeded['legacy/hero/HeroOne']

seeded['legacy/hero/HeroThree'] = heroWithoutVideos
seeded['legacy/hero/HeroTwo'] = {
    ...heroWithoutVideos,
    badge_value_link: '/join',
    video: 'https://cdn.example.com/intro.mp4',
    display_play_button: 'true',
    play_button_text: 'Ver la presentación',
    imgs_1: ['https://cdn.example.com/1.jpg', 'https://cdn.example.com/2.jpg'],
    imgs_2: ['https://cdn.example.com/3.jpg'],
    imgs_3: ['https://cdn.example.com/4.jpg'],
}

// Tipos equivocados en todas las claves que las secciones recorren.
const broken = {
    nav: 'no es una lista',
    videos: { a: 1 },
    imgs_1: 'x',
    imgs_2: null,
    imgs_3: [null, 3, ''],
    images: 'x',
    features: { a: 1 },
    items: [null, 'texto', { question: 42 }, { author: 'x' }],
    feature: 'x',
    frequencies: 5,
    tiers: [null, { name: 'Sin precio', price: null, features: 'x' }],
    cols: [{ items: 'x' }, null],
    newsletter: 'x',
    social_links: ['x'],
    logo: { url: 'x' },
    image: 7,
    content: { html: '<p>x</p>' },
    title: ['x'],
    display_play_button: 'true',
    video: '',
}

const Empty = { render: () => null }

let pinia
let router

const mountSection = async (key, props) => {
    const errors = []

    const wrapper = mount(registry[key], {
        props,
        attachTo: document.body,
        global: {
            plugins: [pinia, router],
            config: {
                errorHandler: (error) => errors.push(error),
            },
        },
    })

    await flushPromises()

    return { wrapper, errors }
}

beforeEach(async () => {
    pinia = createPinia()
    setActivePinia(pinia)

    useOptionsStore().values = { site_name: 'Mi aplicación' }

    router = createRouter({
        history: createMemoryHistory(),
        routes: [
            { path: '/', name: 'site.home', component: Empty },
            { path: '/auth/login', name: 'auth.login', component: Empty },
            { path: '/admin', name: 'admin.dashboard', component: Empty },
            { path: '/:any(.*)*', name: 'not-found', component: Empty },
        ],
    })

    await router.push('/')
    document.body.innerHTML = ''
})

describe.each(Object.keys(registry))('%s', (key) => {
    it('renders with the seeded props', async () => {
        const { wrapper, errors } = await mountSection(key, seeded[key])

        expect(errors).toEqual([])
        expect(wrapper.html()).not.toBe('')

        const title = seeded[key].title

        if (typeof title === 'string' && title !== '') {
            expect(wrapper.text()).toContain(title)
        }

        // Ninguna imagen sin dirección: sin imagen, la sección no deja hueco.
        for (const image of wrapper.findAll('img')) {
            expect(image.attributes('src')).toBeTruthy()
        }

        wrapper.unmount()
    })

    it('renders without images and without the optional arrays', async () => {
        const { wrapper, errors } = await mountSection(key, {})

        expect(errors).toEqual([])
        expect(wrapper.findAll('img')).toHaveLength(0)
        expect(wrapper.find('video').exists()).toBe(false)

        wrapper.unmount()
    })

    it('does not throw with props of the wrong type', async () => {
        const { wrapper, errors } = await mountSection(key, broken)

        expect(errors).toEqual([])

        for (const image of wrapper.findAll('img')) {
            expect(image.attributes('src')).toBeTruthy()
        }

        wrapper.unmount()
    })
})

describe('section behaviour', () => {
    it('HeaderOne offers to sign in, or the administrator when there is a session', async () => {
        const guest = await mountSection('legacy/header/HeaderOne', seeded['legacy/header/HeaderOne'])

        expect(guest.wrapper.find('.site-header-cta').text()).toBe('Sign in')
        expect(guest.wrapper.find('.site-header-cta').attributes('href')).toBe('/auth/login')
        expect(guest.wrapper.findAll('.site-header-link').map((link) => link.text())).toEqual(['Inicio', 'Únete', 'Contacto'])
        // Las redes vienen vacías en la siembra.
        expect(guest.wrapper.find('.site-social').exists()).toBe(false)
        guest.wrapper.unmount()

        useAuthStore().session = { user: { id: 1 }, authenticated: true, is_admin: false, verified: true, impersonating: false }

        const member = await mountSection('legacy/header/HeaderOne', { ...seeded['legacy/header/HeaderOne'], instagram: 'https://instagram.com/acme', facebook: 'javascript:alert(1)' })

        expect(member.wrapper.find('.site-header-cta').text()).toBe('Administrator')
        expect(member.wrapper.find('.site-header-cta').attributes('href')).toBe('/admin')
        expect(member.wrapper.findAll('.site-social a').map((link) => link.attributes('href'))).toEqual(['https://instagram.com/acme'])
        member.wrapper.unmount()
    })

    it('HeaderOne toggles the mobile menu with aria-expanded', async () => {
        const { wrapper } = await mountSection('legacy/header/HeaderOne', seeded['legacy/header/HeaderOne'])
        const toggle = wrapper.find('.site-header-toggle')

        expect(toggle.attributes('aria-expanded')).toBe('false')
        await toggle.trigger('click')
        expect(toggle.attributes('aria-expanded')).toBe('true')
        expect(wrapper.find(`#${toggle.attributes('aria-controls')}`).attributes('data-open')).toBe('true')

        wrapper.unmount()
    })

    it('links starting with / navigate with the router and the rest are plain links', async () => {
        const { wrapper } = await mountSection('legacy/section/MissionSection', { ...seeded['legacy/section/MissionSection'], button_link: '/join' })
        const internal = wrapper.find('.site-actions a')

        await internal.trigger('click')
        await flushPromises()
        expect(router.currentRoute.value.fullPath).toBe('/join')
        wrapper.unmount()

        const external = await mountSection('legacy/section/MissionSection', { ...seeded['legacy/section/MissionSection'], button_link: 'https://example.com' })

        expect(external.wrapper.find('.site-actions a').attributes('href')).toBe('https://example.com')
        external.wrapper.unmount()
    })

    it('HeroTwo shows the image columns and plays the video in a dialog', async () => {
        const { wrapper } = await mountSection('legacy/hero/HeroTwo', seeded['legacy/hero/HeroTwo'])

        expect(wrapper.findAll('.site-hero-column')).toHaveLength(3)
        expect(wrapper.find('video').exists()).toBe(false)

        await wrapper.find('.site-play').trigger('click')
        await flushPromises()

        expect(document.body.querySelector('video.site-video')?.getAttribute('src')).toBe('https://cdn.example.com/intro.mp4')

        wrapper.unmount()
    })

    it('PlansSection switches the prices with the frequency', async () => {
        const { wrapper } = await mountSection('legacy/section/PlansSection', seeded['legacy/section/PlansSection'])
        const prices = () => wrapper.findAll('.site-tier-amount').map((node) => node.text())

        expect(prices()).toEqual(['$0', '$29', '$99'])
        expect(wrapper.find('.site-tier-suffix').text()).toBe('/mes')
        expect(wrapper.find('[data-popular="true"] .site-tier-name').text()).toBe('Equipo')

        await wrapper.findAll('.site-segmented-input')[1].setValue(true)

        expect(prices()).toEqual(['$0', '$290', '$990'])
        expect(wrapper.find('.site-tier-suffix').text()).toBe('/año')

        wrapper.unmount()
    })

    it('FooterOne only shows the social networks that have a link', async () => {
        const props = {
            ...seeded['legacy/footer/FooterOne'],
            social_links: { ...seeded['legacy/footer/FooterOne'].social_links, github: 'https://github.com/acme' },
        }
        const { wrapper } = await mountSection('legacy/footer/FooterOne', props)

        expect(wrapper.findAll('.site-social a').map((link) => link.attributes('aria-label'))).toEqual(['GitHub'])
        expect(wrapper.text()).toContain(`© ${new Date().getFullYear()} Mi aplicación.`)
        expect(wrapper.findAll('.site-footer-links a')).toHaveLength(7)

        wrapper.unmount()
    })

    it('HtmlContent renders the HTML the administrator wrote', async () => {
        const { wrapper } = await mountSection('legacy/section/HtmlContent', seeded['legacy/section/HtmlContent'])

        expect(wrapper.find('.site-prose h1').text()).toBe('Aviso de privacidad')

        wrapper.unmount()
    })

    it('CookieConsentOne remembers the decision in the cookie and does not come back', async () => {
        const first = await mountSection('legacy/cookie-consent/CookieConsentOne', seeded['legacy/cookie-consent/CookieConsentOne'])

        expect(first.wrapper.find('.site-cookie-link').attributes('href')).toBe('/privacy')

        await first.wrapper.findAll('.site-cookie-actions button')[1].trigger('click')

        expect(readConsent()).toBe('rejected')
        expect(document.cookie).toContain(`${CONSENT_COOKIE}=rejected`)
        expect(first.wrapper.find('.site-cookie').exists()).toBe(false)
        first.wrapper.unmount()

        const again = await mountSection('legacy/cookie-consent/CookieConsentOne', seeded['legacy/cookie-consent/CookieConsentOne'])

        expect(again.wrapper.find('.site-cookie').exists()).toBe(false)
        again.wrapper.unmount()
    })
})
