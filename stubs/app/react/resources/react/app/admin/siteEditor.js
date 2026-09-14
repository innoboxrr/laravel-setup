import t from 'innoboxrr-i18n'

import { sitePages } from '../config.js'

/*
 * La lógica del editor del sitio, sin React: pasar la opción `theme` a un
 * borrador editable y volver de él.
 */

let nextUid = 1

export const pageKeysOf = (theme) => [...new Set([
    ...sitePages.map((page) => page.key),
    ...Object.keys(theme && typeof theme === 'object' ? theme : {}),
])]

/**
 * @returns {{ props: Record<string, any> | null, error: string | null }}
 */
export function parseProps(text) {
    let value

    try {
        value = JSON.parse(text)
    } catch (error) {
        return { props: null, error: error.message }
    }

    if (! value || typeof value !== 'object' || Array.isArray(value)) {
        return { props: null, error: t('The props must be a JSON object.') }
    }

    return { props: value, error: null }
}

export const isDisplayed = (props) => props?.display !== false && props?.display !== 'false'

export function toEditableSection(section = {}) {
    const props = section.props && typeof section.props === 'object' && ! Array.isArray(section.props) ? section.props : {}

    return {
        uid: nextUid++,
        theme: section.theme ?? 'legacy',
        group: section.group ?? '',
        name: section.name ?? '',
        text: JSON.stringify(props, null, 2),
        open: false,
    }
}

export function toEditable(theme) {
    const source = theme && typeof theme === 'object' ? theme : {}

    return Object.fromEntries(pageKeysOf(source).map((key) => {
        const { title = '', sections = [], ...rest } = source[key] && typeof source[key] === 'object' ? source[key] : {}

        return [key, {
            title: typeof title === 'string' ? title : '',
            rest,
            sections: (Array.isArray(sections) ? sections : []).map(toEditableSection),
        }]
    }))
}

/**
 * El borrador, de vuelta al formato de la opción `theme`.
 *
 * @returns {{ theme: Record<string, any>, invalid: Array<{ page: string, index: number }> }}
 */
export function toTheme(pages) {
    const invalid = []

    const theme = Object.fromEntries(Object.entries(pages).map(([key, page]) => [key, {
        ...page.rest,
        title: page.title,
        sections: page.sections.map((section, index) => {
            const { props, error } = parseProps(section.text)

            if (error) {
                invalid.push({ page: key, index })
            }

            return { theme: section.theme, group: section.group, name: section.name, props: props ?? {} }
        }),
    }]))

    return { theme, invalid }
}

/** Cambia `display` en el texto, sólo si el JSON es válido. */
export function setDisplay(text, display) {
    const { props } = parseProps(text)

    return props ? JSON.stringify({ ...props, display }, null, 2) : text
}

export function moveItem(list, from, to) {
    if (to < 0 || to >= list.length) {
        return list
    }

    const next = [...list]
    const [item] = next.splice(from, 1)

    next.splice(to, 0, item)

    return next
}
