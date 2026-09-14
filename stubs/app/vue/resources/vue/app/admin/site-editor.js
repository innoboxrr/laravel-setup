import { isDisplayed } from '@app/site/render.js'

/**
 * La lógica del editor del sitio, sin Vue: el borrador de la opción `theme`
 * y lo que se hace con él.
 *
 * Cada sección guarda sus props como el texto que se edita: así un JSON a
 * medio escribir no se pierde ni rompe el resto, y sólo al guardar se exige que
 * todo sea válido.
 */

export const DEFAULT_PAGES = ['home', 'privacy', 'terms', 'contact', 'join']

const isPlainObject = (value) => value !== null && typeof value === 'object' && ! Array.isArray(value)

let counter = 0

export function draftSection(section) {
    const source = isPlainObject(section) ? section : {}
    const { props, ...rest } = source

    return {
        uid: ++counter,
        rest: { theme: 'legacy', group: '', name: '', ...rest },
        propsText: JSON.stringify(isPlainObject(props) ? props : {}, null, 4),
    }
}

/**
 * Las cinco páginas del contrato primero y, detrás, las que la opción ya
 * tuviera de más: nada de lo guardado se pierde al guardar otra vez.
 */
export function createDraft(theme) {
    const source = isPlainObject(theme) ? theme : {}
    const keys = [...DEFAULT_PAGES, ...Object.keys(source).filter((key) => ! DEFAULT_PAGES.includes(key))]

    return keys.map((key) => {
        const page = isPlainObject(source[key]) ? source[key] : {}
        const { title, sections, ...rest } = page

        return {
            key,
            title: typeof title === 'string' ? title : '',
            rest,
            sections: (Array.isArray(sections) ? sections : []).map(draftSection),
        }
    })
}

/**
 * @returns {{ value: object|null, error: null|'syntax'|'not-object', detail?: string }}
 */
export function parseProps(text) {
    let value

    try {
        value = JSON.parse(text)
    } catch (exception) {
        return { value: null, error: 'syntax', detail: exception.message }
    }

    return isPlainObject(value) ? { value, error: null } : { value: null, error: 'not-object' }
}

export function sectionKeyOf(section) {
    return [section.rest.theme, section.rest.group, section.rest.name].join('/')
}

/**
 * `true`/`false`, o null si las props no se pueden leer.
 */
export function sectionVisible(section) {
    const { value, error } = parseProps(section.propsText)

    return error ? null : isDisplayed(value)
}

export function setDisplay(section, visible) {
    const { value, error } = parseProps(section.propsText)

    if (error) {
        return false
    }

    section.propsText = JSON.stringify({ ...value, display: Boolean(visible) }, null, 4)

    return true
}

export function moveSection(sections, index, offset) {
    const target = index + offset

    if (index < 0 || index >= sections.length || target < 0 || target >= sections.length) {
        return false
    }

    const [section] = sections.splice(index, 1)

    sections.splice(target, 0, section)

    return true
}

export function removeSection(sections, index) {
    return sections.splice(index, 1)[0] ?? null
}

export function addSection(sections, key) {
    const [theme, group, name] = String(key).split('/')
    const section = draftSection({ theme, group, name, props: { display: true } })

    sections.push(section)

    return section
}

export function draftErrors(pages) {
    return pages.flatMap((page) => page.sections.flatMap((section, index) => {
        const { error } = parseProps(section.propsText)

        return error ? [{ page: page.key, uid: section.uid, index, error }] : []
    }))
}

/**
 * El valor de la opción `theme`, o los errores que impiden guardarlo.
 */
export function buildTheme(pages) {
    const errors = draftErrors(pages)

    if (errors.length > 0) {
        return { theme: null, errors }
    }

    const theme = {}

    for (const page of pages) {
        theme[page.key] = {
            ...page.rest,
            title: page.title,
            sections: page.sections.map((section) => ({ ...section.rest, props: parseProps(section.propsText).value })),
        }
    }

    return { theme, errors: [] }
}
