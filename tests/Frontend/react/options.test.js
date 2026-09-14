import { describe, expect, it, vi } from 'vitest'

import { createOptionsStore, decodeValue, readPath } from '@app/stores/options.js'

import { optionsWithIds, siteNameFixture, themeFixture } from './helpers.js'

const fakeHttp = () => ({
    get: vi.fn(async () => ({ data: optionsWithIds() })),
    put: vi.fn(async (url, body) => ({ data: { id: body.option_id, key: body.key, name: body.name, value: body.value } })),
    post: vi.fn(async (url, body) => ({ data: { id: 99, ...body } })),
})

const resolve = (name, params) => (params ? `${name}?${new URLSearchParams(params)}` : name)

describe('options store', () => {
    it('loads every option from the public index with paginate=0 and keeps their ids', async () => {
        const http = fakeHttp()
        const store = createOptionsStore({ http, resolve })

        await store.getState().load()

        expect(http.get).toHaveBeenCalledWith('api.laravel-options.option.index?paginate=0')
        expect(store.getState().loaded).toBe(true)
        expect(store.getState().records.theme).toEqual({ id: 3, key: 'theme', name: 'Páginas del sitio' })
    })

    it('decodes JSON objects and arrays only; any other text stays text', async () => {
        const store = createOptionsStore({ http: fakeHttp(), resolve })

        await store.getState().load()

        const { values } = store.getState()

        expect(values.theme).toEqual(themeFixture())
        expect(values.site_name).toBe(siteNameFixture())
        expect(decodeValue('2024')).toBe('2024')
        expect(decodeValue('true')).toBe('true')
        expect(decodeValue('[1,2]')).toEqual([1, 2])
        expect(decodeValue('{broken')).toBe('{broken')
    })

    it('reads nested paths with option() and falls back to the default', async () => {
        const store = createOptionsStore({ http: fakeHttp(), resolve })

        await store.getState().load()

        const { option } = store.getState()

        expect(option('site_name')).toBe(siteNameFixture())
        expect(option('theme.home')).toEqual(themeFixture().home)
        expect(option('theme.home.title')).toBe('Inicio')
        expect(option('theme.missing', 'none')).toBe('none')
        expect(option('theme.home.title.deeper', 'none')).toBe('none')
        expect(option('unknown')).toBeNull()
        expect(readPath({ 'dotted.key': 'kept' }, 'dotted.key')).toBe('kept')
    })

    it('saves a structured value serialized to JSON with the update payload', async () => {
        const http = fakeHttp()
        const store = createOptionsStore({ http, resolve })

        await store.getState().load()

        const theme = themeFixture()
        theme.home.title = 'Portada'

        await store.getState().save('theme', theme)

        expect(http.put).toHaveBeenCalledWith('api.laravel-options.option.update', {
            option_id: 3,
            name: 'Páginas del sitio',
            key: 'theme',
            value: JSON.stringify(theme),
        })

        expect(store.getState().option('theme.home.title')).toBe('Portada')
    })

    it('saves text as it is', async () => {
        const http = fakeHttp()
        const store = createOptionsStore({ http, resolve })

        await store.getState().load()
        await store.getState().save('site_name', 'Nueva')

        expect(http.put).toHaveBeenCalledWith('api.laravel-options.option.update', { option_id: 1, name: 'Nombre del sitio', key: 'site_name', value: 'Nueva' })
        expect(store.getState().values.site_name).toBe('Nueva')
    })

    it('creates an option that does not exist yet', async () => {
        const http = fakeHttp()
        const store = createOptionsStore({ http, resolve })

        await store.getState().load()
        await store.getState().save('footer_note', { text: 'Hola' })

        expect(http.put).not.toHaveBeenCalled()
        expect(http.post).toHaveBeenCalledWith('api.laravel-options.option.create', { key: 'footer_note', name: 'footer_note', value: '{"text":"Hola"}' })
        expect(store.getState().records.footer_note.id).toBe(99)
    })
})
