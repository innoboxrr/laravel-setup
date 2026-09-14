import { Component } from 'react'
import { afterEach, describe, expect, it } from 'vitest'
import { fireEvent, render } from '@testing-library/react'
import { MemoryRouter } from 'react-router-dom'

import sections, { sectionKey } from '@app/site/sections/index.js'

import { themeFixture } from './helpers.js'

class Catcher extends Component {
    static getDerivedStateFromError() {
        return { failed: true }
    }

    state = { failed: false }

    componentDidCatch(error) {
        this.props.errors.push(error)
    }

    render() {
        return this.state.failed ? null : this.props.children
    }
}

const renderSection = (key, props) => {
    const errors = []
    const SectionComponent = sections[key]

    const result = render(
        <MemoryRouter>
            <Catcher errors={errors}>
                <SectionComponent props={props} />
            </Catcher>
        </MemoryRouter>
    )

    return { ...result, errors }
}

// Las props sembradas de cada sección; HeroTwo y HeroThree no están en la
// siembra y se construyen desde las de HeroOne, con las claves que añaden.
const seeded = (() => {
    const found = {}

    Object.values(themeFixture()).forEach((page) => page.sections.forEach((section) => {
        found[sectionKey(section)] ??= section.props
    }))

    const { videos, ...hero } = found['legacy/hero/HeroOne']

    found['legacy/hero/HeroTwo'] ??= {
        ...hero,
        badge_value_link: '/join',
        video: 'https://example.com/intro.mp4',
        display_play_button: 'true',
        play_button_text: 'Ver el video',
        imgs_1: ['https://example.com/1.jpg', 'https://example.com/2.jpg'],
        imgs_2: [],
        imgs_3: ['https://example.com/3.jpg'],
    }

    found['legacy/hero/HeroThree'] ??= { ...hero }

    return found
})()

const keys = Object.keys(sections)

describe('site sections', () => {
    afterEach(() => {
        document.cookie = 'cookie_consent=; max-age=0; path=/'
    })

    it('registers the 13 legacy sections', () => {
        expect(keys).toHaveLength(13)
        keys.forEach((key) => expect(seeded[key], key).toBeDefined())
    })

    it.each(keys)('%s renders with the seeded props', (key) => {
        const { container, errors } = renderSection(key, seeded[key])

        expect(errors).toEqual([])
        expect(container.textContent.length).toBeGreaterThan(0)

        // La siembra no trae imágenes: ninguna etiqueta img sin fuente.
        container.querySelectorAll('img').forEach((img) => expect(img.getAttribute('src')).toBeTruthy())
    })

    it.each(keys)('%s renders without images or optional arrays', (key) => {
        const { container, errors } = renderSection(key, { display: true })

        expect(errors).toEqual([])
        expect(container.querySelectorAll('img')).toHaveLength(0)
    })

    it.each(keys)('%s survives props of the wrong type', (key) => {
        const { errors } = renderSection(key, {
            nav: 'x', videos: 'x', images: {}, features: 7, items: 'x', feature: [], frequencies: {}, tiers: 'x',
            cols: {}, newsletter: 'x', social_links: [], imgs_1: 'x', price: null, content: 5, title: { a: 1 },
        })

        expect(errors).toEqual([])
    })

    it('CookieConsentOne remembers the decision in the cookie_consent cookie', async () => {
        const { getByRole, container, unmount } = renderSection('legacy/cookie-consent/CookieConsentOne', seeded['legacy/cookie-consent/CookieConsentOne'])

        fireEvent.click(getByRole('button', { name: 'Rechazar' }))

        expect(document.cookie).toContain('cookie_consent=rejected')

        unmount()

        const again = renderSection('legacy/cookie-consent/CookieConsentOne', seeded['legacy/cookie-consent/CookieConsentOne'])

        expect(again.container.textContent).toBe('')
        expect(container.textContent).toBe('')
    })

    it('CookieConsentOne links the policy as "Learn more"', () => {
        const { getByRole } = renderSection('legacy/cookie-consent/CookieConsentOne', seeded['legacy/cookie-consent/CookieConsentOne'])

        expect(getByRole('link', { name: 'Learn more' }).getAttribute('href')).toBe('/privacy')
    })

    it('TestimonialsSection also accepts the legacy `message` key', () => {
        const { container } = renderSection('legacy/section/TestimonialsSection', {
            items: [{ message: 'Texto de una aplicación antigua', author: { name: 'Ana' } }],
        })

        expect(container.textContent).toContain('Texto de una aplicación antigua')
    })

    it('HeroTwo shows the play button only with a video and display_play_button', () => {
        const withoutVideo = renderSection('legacy/hero/HeroTwo', { title: 'Hola', display_play_button: true })

        expect(withoutVideo.queryByRole('button', { name: 'Play video' })).toBeNull()
        withoutVideo.unmount()

        const hidden = renderSection('legacy/hero/HeroTwo', { title: 'Hola', video: 'https://example.com/v.mp4', display_play_button: false })

        expect(hidden.queryByRole('button', { name: 'Play video' })).toBeNull()
        hidden.unmount()

        const shown = renderSection('legacy/hero/HeroTwo', { title: 'Hola', video: 'https://example.com/v.mp4', display_play_button: '1' })

        expect(shown.getByRole('button', { name: 'Play video' })).toBeInTheDocument()
    })

    it('PlansSection links each tier with "Choose plan"', () => {
        const { getAllByRole } = renderSection('legacy/section/PlansSection', seeded['legacy/section/PlansSection'])

        expect(getAllByRole('link', { name: 'Choose plan' })).toHaveLength(3)
    })

    it('never turns a javascript: link into an href', () => {
        const { container } = renderSection('legacy/section/JoinSection', { title: 'Hola', button_text: 'Pulsa', button_link: ' javascript:alert(1)' })

        expect(container.querySelector('a')).toBeNull()
        expect(container.textContent).toContain('Pulsa')
    })

    it('HeaderOne links internal paths with the router and shows the sign-in link to guests', () => {
        const { getByRole } = renderSection('legacy/header/HeaderOne', seeded['legacy/header/HeaderOne'])

        expect(getByRole('link', { name: 'Únete' }).getAttribute('href')).toBe('/join')
        expect(getByRole('link', { name: 'Sign in' }).getAttribute('href')).toBe('/auth/login')
    })
})
