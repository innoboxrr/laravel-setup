/**
 * Qué secciones de una página se pintan, sin montar nada: el mismo cálculo lo
 * usan el sitio y las pruebas.
 */

export function sectionKey(section) {
    return [section?.theme, section?.group, section?.name].join('/')
}

/**
 * Sin la clave se pinta; `false` o `"false"` (el formato antiguo guardaba los
 * booleanos como texto) la ocultan.
 */
export function isDisplayed(props) {
    const display = props?.display

    return ! (display === false || display === 'false')
}

const LEADING_GROUPS = ['header']

const TRAILING_GROUPS = ['footer', 'cookie-consent']

/**
 * @returns {Array<{ key: string, name: string, group: string, component: object, props: object }>}
 */
export function renderableSections(page, registry, warn = (message) => console.warn(message)) {
    const sections = Array.isArray(page?.sections) ? page.sections : []

    return sections.flatMap((section, index) => {
        if (! section || typeof section !== 'object') {
            return []
        }

        const props = section.props && typeof section.props === 'object' && ! Array.isArray(section.props)
            ? section.props
            : {}

        if (! isDisplayed(props)) {
            return []
        }

        const name = sectionKey(section)
        const component = Object.hasOwn(registry ?? {}, name) ? registry[name] : null

        if (! component) {
            warn(`[site] The section "${name}" is not registered; it is not rendered.`)

            return []
        }

        return [{ key: `${index}:${name}`, name, group: String(section.group ?? ''), component, props }]
    })
}

/**
 * Las cabeceras del principio y los pies del final quedan fuera de `<main>`,
 * sin cambiar el orden: el resto es el contenido de la página.
 */
export function splitLandmarks(items) {
    let start = 0

    while (start < items.length && LEADING_GROUPS.includes(items[start].group)) {
        start++
    }

    let end = items.length

    while (end > start && TRAILING_GROUPS.includes(items[end - 1].group)) {
        end--
    }

    return {
        before: items.slice(0, start),
        main: items.slice(start, end),
        after: items.slice(end),
    }
}
