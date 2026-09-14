import { afterEach, beforeEach, describe, expect, it, vi } from 'vitest'
import axios from 'axios'
import { createPinia, setActivePinia } from 'pinia'
import { setRoutes } from 'innoboxrr-route-resolver'
import {
    buildSaveRequest,
    decodeOptions,
    decodeValue,
    readOption,
    serializeValue,
    useOptionsStore,
} from '@app/stores/options.js'
import routes from '../fixtures/routes.json'
import fixture from '../../fixtures/options.json'

// El index real trae el id de cada opción (JsonResource sin envoltorio); el
// fixture compartido sólo trae key, name y value.
const withIds = fixture.map((option, index) => ({ id: index + 1, ...option }))

describe('decoding', () => {
    it('decodes JSON objects and arrays and leaves any other text alone', () => {
        expect(decodeValue('{"a":{"b":1}}')).toEqual({ a: { b: 1 } })
        expect(decodeValue(' [1,2] ')).toEqual([1, 2])
        expect(decodeValue('Mi aplicación')).toBe('Mi aplicación')
        expect(decodeValue('2024')).toBe('2024')
        expect(decodeValue('true')).toBe('true')
        expect(decodeValue('{ roto')).toBe('{ roto')
        expect(decodeValue(null)).toBeNull()
    })

    it('reads the options index as values and records by key', () => {
        const { values, records } = decodeOptions(withIds)

        expect(values.site_name).toBe('Mi aplicación')
        expect(values.theme.home.title).toBe('Inicio')
        expect(records.theme).toEqual({ id: 3, name: 'Páginas del sitio' })
        expect(decodeOptions({ data: withIds }).values.site_description).toBe('Una aplicación lista para crecer.')
        expect(decodeOptions(null)).toEqual({ values: {}, records: {} })
    })

    it('walks into the JSON with dots and falls back to the default', () => {
        const { values } = decodeOptions(fixture)

        expect(readOption(values, 'site_name')).toBe('Mi aplicación')
        expect(readOption(values, 'theme.home.title')).toBe('Inicio')
        expect(readOption(values, 'theme.home.sections')).toHaveLength(9)
        expect(readOption(values, 'theme.home.sections.1.name')).toBe('HeroOne')
        expect(readOption(values, 'theme.blog.title', 'Blog')).toBe('Blog')
        expect(readOption(values, 'missing', 'x')).toBe('x')
        expect(readOption(values, 'site_name.length', 'x')).toBe('x')
        expect(readOption({ 'a.b': 'literal' }, 'a.b')).toBe('literal')
    })

    it('serializes anything that is not text', () => {
        expect(serializeValue('Hola')).toBe('Hola')
        expect(serializeValue({ a: [1] })).toBe('{"a":[1]}')
        expect(serializeValue(null)).toBeNull()
    })

    it('updates an existing option and creates a missing one', () => {
        expect(buildSaveRequest('theme', { home: {} }, { id: 3, name: 'Páginas' })).toEqual({
            method: 'put',
            route: 'api.laravel-options.option.update',
            data: { option_id: 3, value: '{"home":{}}' },
        })
        expect(buildSaveRequest('footer_text', 'Hola', undefined)).toEqual({
            method: 'post',
            route: 'api.laravel-options.option.create',
            data: { key: 'footer_text', name: 'footer_text', value: 'Hola' },
        })
    })
})

describe('useOptionsStore', () => {
    beforeEach(() => {
        setRoutes(routes)
        setActivePinia(createPinia())
    })

    afterEach(() => {
        vi.restoreAllMocks()
    })

    it('loads every option, public and unpaginated', async () => {
        const get = vi.spyOn(axios, 'get').mockResolvedValue({ data: withIds })
        const store = useOptionsStore()

        await store.load()

        expect(get).toHaveBeenCalledTimes(1)
        expect(get.mock.calls[0][0]).toMatch(/\/api\/laravel-options\/option\/index\?paginate=0$/)
        expect(store.option('site_name')).toBe('Mi aplicación')
        expect(store.option('theme.home')).toMatchObject({ title: 'Inicio' })
        expect(store.option('theme.join.sections.0.name')).toBe('HeaderOne')
        expect(store.option('theme.nope', 'default')).toBe('default')
        expect(store.loaded).toBe(true)
    })

    it('saves structured values as JSON through the update and keeps the state in sync', async () => {
        vi.spyOn(axios, 'get').mockResolvedValue({ data: withIds })
        const put = vi.spyOn(axios, 'put').mockImplementation(async (url, data) => ({ data: { id: 3, key: 'theme', name: 'Páginas del sitio', value: data.value } }))
        const store = useOptionsStore()

        await store.load()

        const theme = { home: { title: 'Nueva portada', sections: [] } }

        await store.save('theme', theme)

        expect(put).toHaveBeenCalledTimes(1)
        expect(put.mock.calls[0][0]).toMatch(/\/api\/laravel-options\/option\/update$/)
        expect(put.mock.calls[0][1]).toEqual({ option_id: 3, value: JSON.stringify(theme) })
        expect(store.option('theme.home.title')).toBe('Nueva portada')

        // El estado es una copia: tocar el objeto enviado no cambia el sitio.
        theme.home.title = 'Otra'
        expect(store.option('theme.home.title')).toBe('Nueva portada')
    })

    it('saves text as it is', async () => {
        vi.spyOn(axios, 'get').mockResolvedValue({ data: withIds })
        const put = vi.spyOn(axios, 'put').mockResolvedValue({ data: { id: 1 } })
        const store = useOptionsStore()

        await store.load()
        await store.save('site_name', 'Otra aplicación')

        expect(put.mock.calls[0][1]).toEqual({ option_id: 1, value: 'Otra aplicación' })
        expect(store.option('site_name')).toBe('Otra aplicación')
    })

    it('creates an option that does not exist yet and remembers its id', async () => {
        const post = vi.spyOn(axios, 'post').mockResolvedValue({ data: { id: 9, key: 'footer_text', name: 'footer_text' } })
        const put = vi.spyOn(axios, 'put').mockResolvedValue({ data: { id: 9 } })
        const store = useOptionsStore()

        await store.save('footer_text', 'Hola')
        await store.save('footer_text', 'Adiós')

        expect(post).toHaveBeenCalledTimes(1)
        expect(post.mock.calls[0][1]).toEqual({ key: 'footer_text', name: 'footer_text', value: 'Hola' })
        expect(put.mock.calls[0][1]).toEqual({ option_id: 9, value: 'Adiós' })
        expect(store.option('footer_text')).toBe('Adiós')
    })

    it('does not change the state when the save fails', async () => {
        vi.spyOn(axios, 'get').mockResolvedValue({ data: withIds })
        vi.spyOn(axios, 'put').mockRejectedValue({ response: { status: 422, data: { errors: { value: ['The value field must be a string.'] } } } })
        const store = useOptionsStore()

        await store.load()

        await expect(store.save('site_name', 'X')).rejects.toMatchObject({ response: { status: 422 } })
        expect(store.option('site_name')).toBe('Mi aplicación')
    })
})
