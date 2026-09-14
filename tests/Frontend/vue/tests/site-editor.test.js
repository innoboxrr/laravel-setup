import { afterEach, beforeEach, describe, expect, it, vi } from 'vitest'
import { flushPromises, mount } from '@vue/test-utils'
import { createPinia, setActivePinia } from 'pinia'
import { createMemoryHistory, createRouter } from 'vue-router'
import { getToasts, resetToasts } from 'innoboxrr-form-core'
import SiteEditorView from '@app/admin/SiteEditorView.vue'
import {
    addSection,
    buildTheme,
    createDraft,
    moveSection,
    parseProps,
    removeSection,
    sectionVisible,
    setDisplay,
} from '@app/admin/site-editor.js'
import { buildRoutes } from '@app/router/index.js'
import { decodeOptions, useOptionsStore } from '@app/stores/options.js'
import fixture from '../../fixtures/options.json'

const theme = () => JSON.parse(fixture.find((option) => option.key === 'theme').value)

describe('site editor logic', () => {
    it('keeps the theme intact through the draft', () => {
        const source = { ...theme(), landing: { title: 'Campaña', sections: [], layout: 'wide' } }
        const draft = createDraft(source)

        expect(draft.map((page) => page.key)).toEqual(['home', 'privacy', 'terms', 'contact', 'join', 'landing'])
        expect(buildTheme(draft)).toEqual({ theme: source, errors: [] })
    })

    it('starts the five pages even when the option is empty', () => {
        const { theme: built } = buildTheme(createDraft(null))

        expect(Object.keys(built)).toEqual(['home', 'privacy', 'terms', 'contact', 'join'])
        expect(built.home).toEqual({ title: '', sections: [] })
    })

    it('moves, hides, removes and adds sections', () => {
        const [home] = createDraft(theme())

        expect(moveSection(home.sections, 1, -1)).toBe(true)
        expect(home.sections.map((section) => section.rest.name).slice(0, 2)).toEqual(['HeroOne', 'HeaderOne'])
        expect(moveSection(home.sections, 0, -1)).toBe(false)

        expect(setDisplay(home.sections[0], false)).toBe(true)
        expect(sectionVisible(home.sections[0])).toBe(false)

        const removed = removeSection(home.sections, home.sections.length - 1)

        expect(removed.rest.name).toBe('CookieConsentOne')

        const added = addSection(home.sections, 'legacy/hero/HeroThree')

        expect(added.rest).toEqual({ theme: 'legacy', group: 'hero', name: 'HeroThree' })

        const { theme: built } = buildTheme([home])

        expect(built.home.sections[0]).toMatchObject({ name: 'HeroOne', props: { display: false } })
        expect(built.home.sections.at(-1)).toEqual({ theme: 'legacy', group: 'hero', name: 'HeroThree', props: { display: true } })
    })

    it('refuses invalid JSON and props that are not an object', () => {
        const pages = createDraft(theme())

        pages[0].sections[2].propsText = '{ "title": '
        pages[4].sections[0].propsText = '[1, 2]'

        const { theme: built, errors } = buildTheme(pages)

        expect(built).toBeNull()
        expect(errors.map((error) => [error.page, error.index, error.error])).toEqual([
            ['home', 2, 'syntax'],
            ['join', 0, 'not-object'],
        ])
        expect(parseProps('{"a":1}')).toEqual({ value: { a: 1 }, error: null })
        expect(setDisplay(pages[0].sections[2], true)).toBe(false)
    })
})

describe('SiteEditorView', () => {
    let options
    let save

    const mountEditor = async () => {
        const router = createRouter({ history: createMemoryHistory(), routes: buildRoutes([]) })

        await router.push('/')

        const wrapper = mount(SiteEditorView, { attachTo: document.body, global: { plugins: [router] } })

        await flushPromises()

        return wrapper
    }

    const button = (wrapper, label) => wrapper.find(`button[aria-label="${label}"]`)

    const saveButton = (wrapper) => wrapper.find('.editor-savebar button')

    beforeEach(() => {
        setActivePinia(createPinia())
        resetToasts()

        options = useOptionsStore()

        const decoded = decodeOptions(fixture.map((option, index) => ({ id: index + 1, ...option })))

        options.values = decoded.values
        options.records = decoded.records

        save = vi.spyOn(options, 'save').mockResolvedValue({})
    })

    afterEach(() => {
        vi.restoreAllMocks()
        document.body.innerHTML = ''
    })

    it('shows one tab per page and the sections of the selected one in order', async () => {
        const wrapper = await mountEditor()

        expect(wrapper.findAll('[role="tab"]').map((tab) => tab.text())).toEqual(['Inicio', 'Aviso de privacidad', 'Términos y condiciones', 'Contacto', 'Únete'])
        expect(wrapper.findAll('.editor-section-name small').map((node) => node.text())).toEqual([
            'legacy/header/HeaderOne',
            'legacy/hero/HeroOne',
            'legacy/section/MissionSection',
            'legacy/section/TestimonialsSection',
            'legacy/section/FaqSection',
            'legacy/section/PartnersSection',
            'legacy/section/JoinSection',
            'legacy/footer/FooterOne',
            'legacy/cookie-consent/CookieConsentOne',
        ])
        expect(wrapper.find('input[aria-label="Show PartnersSection"]').element.checked).toBe(false)
        expect(wrapper.find('.editor-page-head a').attributes('href')).toBe('/')

        await wrapper.findAll('[role="tab"]')[4].trigger('click')

        expect(wrapper.findAll('.editor-section-name small').map((node) => node.text())[1]).toBe('legacy/section/JoinSection')
        expect(wrapper.find('.editor-page-head a').attributes('href')).toBe('/join')

        wrapper.unmount()
    })

    it('marks invalid JSON and does not let it be saved', async () => {
        const wrapper = await mountEditor()

        await button(wrapper, 'Edit the props of HeroOne').trigger('click')
        await wrapper.find('.codemirror-stub').setValue('{ "title": "Sin cerrar"')

        expect(wrapper.find('.editor-section[data-invalid="true"]').exists()).toBe(true)
        expect(wrapper.find('.editor-props .fe-error').text()).toBe('This is not valid JSON.')
        expect(wrapper.find('[role="tab"][aria-selected="true"] .fe-badge-danger').exists()).toBe(true)
        expect(saveButton(wrapper).attributes('disabled')).toBeDefined()
        expect(wrapper.find('.editor-savebar-status').text()).toBe('Fix the invalid JSON to save.')

        await saveButton(wrapper).trigger('click')
        await flushPromises()

        expect(save).not.toHaveBeenCalled()

        // Arreglado, se puede volver a guardar.
        await wrapper.find('.codemirror-stub').setValue('{ "title": "Cerrado" }')

        expect(saveButton(wrapper).attributes('disabled')).toBeUndefined()

        wrapper.unmount()
    })

    it('saves the changes through the options store and says so', async () => {
        const wrapper = await mountEditor()

        await wrapper.find('input[aria-label="Show HeroOne"]').setValue(false)
        await button(wrapper, 'Move MissionSection up').trigger('click')
        await wrapper.find('input[name="page-title-home"]').setValue('Portada')
        await wrapper.find('input[name="site_name"]').setValue('Acme')

        expect(wrapper.find('.editor-savebar-status').text()).toBe('Unsaved changes')

        await saveButton(wrapper).trigger('click')
        await flushPromises()

        expect(save.mock.calls.map((call) => call[0])).toEqual(['site_name', 'theme'])
        expect(save).toHaveBeenCalledWith('site_name', 'Acme')

        const saved = save.mock.calls[1][1]

        expect(saved.home.title).toBe('Portada')
        expect(saved.home.sections.map((section) => section.name).slice(0, 3)).toEqual(['HeaderOne', 'MissionSection', 'HeroOne'])
        expect(saved.home.sections[2].props.display).toBe(false)
        expect(saved.privacy).toEqual(theme().privacy)
        expect(getToasts().map((toast) => toast.message)).toContain('Site saved')
        expect(wrapper.find('.editor-savebar-status').text()).toBe('')

        wrapper.unmount()
    })

    it('adds and removes sections from the registry', async () => {
        const wrapper = await mountEditor()

        await wrapper.findAll('[role="tab"]')[2].trigger('click')
        await wrapper.find('.editor-add select').setValue('legacy/section/FaqSection')
        await wrapper.find('.editor-add button').trigger('click')
        await button(wrapper, 'Remove HtmlContent').trigger('click')
        await saveButton(wrapper).trigger('click')
        await flushPromises()

        expect(save.mock.calls.at(-1)[1].terms.sections.map((section) => section.name)).toEqual(['HeaderOne', 'FooterOne', 'FaqSection'])

        wrapper.unmount()
    })

    it('shows the validation error of a 422', async () => {
        save.mockRejectedValue({ response: { status: 422, data: { message: 'Invalid', errors: { value: ['The value field must be a string.'] } } } })

        const wrapper = await mountEditor()

        await saveButton(wrapper).trigger('click')
        await flushPromises()

        expect(wrapper.find('.app-alert').text()).toBe('The value field must be a string.')
        expect(getToasts().some((toast) => toast.variant === 'danger')).toBe(true)

        wrapper.unmount()
    })
})
