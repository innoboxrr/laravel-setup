import { beforeEach, describe, expect, it, vi } from 'vitest'
import { fireEvent, render, screen, waitFor } from '@testing-library/react'
import { MemoryRouter } from 'react-router-dom'

import SiteEditorView from '@app/admin/SiteEditorView.jsx'
import { useOptionsStore } from '@app/stores/options.js'

import { optionsWithIds, themeFixture } from './helpers.js'

// CodeMirror no se puede escribir desde jsdom; su sitio lo ocupa un textarea
// con el mismo contrato (label, value, onChange con el texto).
vi.mock('@app/admin/components/JsonEditor.jsx', () => ({
    default: ({ label, value, onChange }) => (
        <textarea aria-label={label} value={value} onChange={(event) => onChange(event.target.value)} />
    ),
}))

const renderEditor = () => render(
    <MemoryRouter>
        <SiteEditorView />
    </MemoryRouter>
)

const savedTheme = (save) => save.mock.calls.find(([key]) => key === 'theme')?.[1]

describe('site editor', () => {
    let save

    beforeEach(() => {
        save = vi.fn(async () => ({}))

        useOptionsStore.getState().hydrate(optionsWithIds())
        useOptionsStore.setState({ save })
    })

    it('shows one tab per page and the sections of the selected one, in order', () => {
        renderEditor()

        expect(screen.getAllByRole('tab').map((tab) => tab.textContent)).toEqual(['Home', 'Privacy', 'Terms', 'Contact', 'Join'])
        expect(screen.getByRole('tab', { name: 'Home' })).toHaveAttribute('aria-selected', 'true')

        const names = screen.getAllByRole('listitem').map((item) => item.querySelector('strong')?.textContent).filter(Boolean)

        expect(names).toEqual(themeFixture().home.sections.map((section) => section.name))
    })

    it('refuses to save invalid JSON', () => {
        renderEditor()

        fireEvent.click(screen.getAllByRole('button', { name: 'Edit props' })[0])
        fireEvent.change(screen.getByLabelText('Props of HeaderOne'), { target: { value: '{"display": true,' } })

        const button = screen.getByRole('button', { name: 'Save' })

        expect(button).toBeDisabled()
        expect(screen.getAllByRole('alert').length).toBeGreaterThan(0)

        fireEvent.click(button)

        expect(save).not.toHaveBeenCalled()
    })

    it('saves valid changes through the options store, and only the theme when the name did not change', async () => {
        renderEditor()

        const original = themeFixture()
        const props = { ...original.home.sections[0].props, logo: '/images/logo.svg' }

        fireEvent.click(screen.getAllByRole('button', { name: 'Edit props' })[0])
        fireEvent.change(screen.getByLabelText('Props of HeaderOne'), { target: { value: JSON.stringify(props) } })

        // Ocultar la sección de preguntas frecuentes con su interruptor.
        fireEvent.click(screen.getByRole('switch', { name: 'Show FaqSection' }))

        fireEvent.click(screen.getByRole('button', { name: 'Save' }))

        await waitFor(() => expect(save).toHaveBeenCalledWith('theme', expect.any(Object)))

        expect(save).toHaveBeenCalledTimes(1)

        const theme = savedTheme(save)

        expect(theme.home.sections).toHaveLength(original.home.sections.length)
        expect(theme.home.sections[0].props).toEqual(props)
        expect(theme.home.sections.find((section) => section.name === 'FaqSection').props.display).toBe(false)
        expect(theme.privacy).toEqual(original.privacy)
        expect(theme.join).toEqual(original.join)
    })

    it('saves the site name and description when they change', async () => {
        renderEditor()

        fireEvent.change(screen.getByLabelText('Site name'), { target: { value: 'Otra aplicación' } })
        fireEvent.click(screen.getByRole('button', { name: 'Save' }))

        await waitFor(() => expect(save).toHaveBeenCalledWith('theme', expect.any(Object)))

        expect(save.mock.calls.map(([key]) => key)).toEqual(['site_name', 'theme'])
        expect(save).toHaveBeenCalledWith('site_name', 'Otra aplicación')
    })

    it('shows the validation errors of a 422', async () => {
        save.mockRejectedValueOnce({ response: { status: 422, data: { message: 'Invalid.', errors: { value: ['The value field must be a string.'] } } } })

        renderEditor()

        fireEvent.click(screen.getByRole('button', { name: 'Save' }))

        expect(await screen.findByText('The value field must be a string.', { selector: '.app-banner' })).toBeInTheDocument()
    })

    it('keeps extra pages and unregistered sections', async () => {
        const theme = themeFixture()

        theme.landing = { title: 'Landing', sections: [{ theme: 'custom', group: 'hero', name: 'Promo', props: { display: true, text: 'Hola' } }] }

        useOptionsStore.getState().hydrate(optionsWithIds().map((option) => (option.key === 'theme' ? { ...option, value: JSON.stringify(theme) } : option)))
        useOptionsStore.setState({ save })

        renderEditor()

        fireEvent.click(screen.getByRole('tab', { name: 'landing' }))

        expect(screen.getByText('Promo')).toBeInTheDocument()
        expect(screen.getByText('Unknown')).toBeInTheDocument()

        fireEvent.click(screen.getByRole('button', { name: 'Save' }))

        await waitFor(() => expect(save).toHaveBeenCalledWith('theme', expect.any(Object)))

        expect(savedTheme(save).landing).toEqual(theme.landing)
    })

    it('moves, removes and adds sections', async () => {
        const confirm = vi.spyOn(window, 'confirm').mockImplementation(() => true)

        renderEditor()

        fireEvent.click(screen.getByRole('button', { name: 'Move HeroOne up' }))
        fireEvent.click(screen.getByRole('button', { name: 'Remove CookieConsentOne' }))

        await waitFor(() => expect(screen.queryByRole('button', { name: 'Remove CookieConsentOne' })).toBeNull())

        fireEvent.change(screen.getByLabelText('Add a section'), { target: { value: 'legacy/hero/HeroThree' } })
        fireEvent.click(screen.getByRole('button', { name: 'Add' }))

        fireEvent.click(screen.getByRole('button', { name: 'Save' }))

        await waitFor(() => expect(save).toHaveBeenCalledWith('theme', expect.any(Object)))

        const names = savedTheme(save).home.sections.map((section) => section.name)

        expect(names.slice(0, 2)).toEqual(['HeroOne', 'HeaderOne'])
        expect(names).not.toContain('CookieConsentOne')
        expect(savedTheme(save).home.sections.at(-1)).toEqual({ theme: 'legacy', group: 'hero', name: 'HeroThree', props: { display: true } })

        confirm.mockRestore()
    })
})
