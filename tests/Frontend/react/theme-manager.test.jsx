import { describe, expect, it, vi } from 'vitest'
import { render } from '@testing-library/react'

import ThemeManager, { splitLandmarks, visibleSections } from '@app/site/ThemeManager.jsx'

import { themeFixture } from './helpers.js'

const Probe = ({ props }) => <p data-testid="section">{props.label}</p>

const registry = {
    'legacy/test/Alpha': Probe,
    'legacy/test/Beta': Probe,
}

const section = (name, props) => ({ theme: 'legacy', group: 'test', name, props })

const sections = [
    section('Beta', { label: 'one', display: true }),
    section('Alpha', { label: 'hidden-bool', display: false }),
    section('Alpha', { label: 'hidden-string', display: 'false' }),
    section('Missing', { label: 'unknown', display: true }),
    section('Alpha', { label: 'no-display-key' }),
    section('Beta', { label: 'string-true', display: 'true' }),
]

describe('ThemeManager', () => {
    it('keeps the order and skips hidden and unknown sections', () => {
        const warn = vi.fn()

        const list = visibleSections(sections, registry, warn)

        expect(list.map((item) => item.props.label)).toEqual(['one', 'no-display-key', 'string-true'])
        expect(warn).toHaveBeenCalledTimes(1)
        expect(warn.mock.calls[0][0]).toContain('legacy/test/Missing')
    })

    it('renders the visible sections in order', () => {
        const warn = vi.spyOn(console, 'warn').mockImplementation(() => {})

        const { getAllByTestId } = render(<ThemeManager sections={sections} registry={registry} />)

        expect(getAllByTestId('section').map((node) => node.textContent)).toEqual(['one', 'no-display-key', 'string-true'])

        warn.mockRestore()
    })

    it('wraps the content in <main> and leaves the leading header and trailing footer outside, in order', () => {
        const chrome = {
            'legacy/header/Top': ({ props }) => <header data-testid="section">{props.label}</header>,
            'legacy/section/Body': Probe,
            'legacy/footer/Bottom': ({ props }) => <footer data-testid="section">{props.label}</footer>,
            'legacy/cookie-consent/Banner': Probe,
        }

        const page = [
            { theme: 'legacy', group: 'header', name: 'Top', props: { label: 'header' } },
            { theme: 'legacy', group: 'section', name: 'Body', props: { label: 'first' } },
            { theme: 'legacy', group: 'section', name: 'Body', props: { label: 'second' } },
            { theme: 'legacy', group: 'footer', name: 'Bottom', props: { label: 'footer' } },
            { theme: 'legacy', group: 'cookie-consent', name: 'Banner', props: { label: 'cookies' } },
        ]

        const { container, getByRole, getAllByTestId } = render(<ThemeManager sections={page} registry={chrome} />)

        expect(getAllByTestId('section').map((node) => node.textContent)).toEqual(['header', 'first', 'second', 'footer', 'cookies'])
        expect([...getByRole('main').querySelectorAll('[data-testid="section"]')].map((node) => node.textContent)).toEqual(['first', 'second'])
        expect(container.querySelector('main header')).toBeNull()
        expect(container.querySelector('main footer')).toBeNull()
    })

    it('splits the seeded home page into header, content and footer', () => {
        const { before, main, after } = splitLandmarks(visibleSections(themeFixture().home.sections))

        expect(before.map((item) => item.name)).toEqual(['legacy/header/HeaderOne'])
        expect(main.map((item) => item.name)).toEqual([
            'legacy/hero/HeroOne',
            'legacy/section/MissionSection',
            'legacy/section/TestimonialsSection',
            'legacy/section/FaqSection',
            'legacy/section/JoinSection',
        ])
        expect(after.map((item) => item.name)).toEqual(['legacy/footer/FooterOne', 'legacy/cookie-consent/CookieConsentOne'])
    })

    it('ignores anything that is not a list of sections', () => {
        expect(visibleSections(null, registry)).toEqual([])
        expect(visibleSections([null, 'text', section('Alpha', ['not', 'an', 'object'])], registry).map((item) => item.props)).toEqual([{}])
    })

    it('shows the seeded home page without the hidden partners section', () => {
        const names = visibleSections(themeFixture().home.sections).map((item) => item.name)

        expect(names).toEqual([
            'legacy/header/HeaderOne',
            'legacy/hero/HeroOne',
            'legacy/section/MissionSection',
            'legacy/section/TestimonialsSection',
            'legacy/section/FaqSection',
            'legacy/section/JoinSection',
            'legacy/footer/FooterOne',
            'legacy/cookie-consent/CookieConsentOne',
        ])
    })
})
