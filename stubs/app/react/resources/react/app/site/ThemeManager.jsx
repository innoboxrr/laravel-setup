import { Component, useMemo } from 'react'

import defaultRegistry, { sectionKey } from './sections/index.js'
import { asArray } from './sections/shared.jsx'

const LEADING_GROUPS = ['header']

const TRAILING_GROUPS = ['footer', 'cookie-consent']

/**
 * Las secciones que se pintan, en su orden: sin las que tienen `display` en
 * `false` o `"false"` (sin la clave, sí se pintan) y sin las que no existen en
 * el registro, que avisan en consola.
 *
 * @returns {Array<{ key: string, name: string, group: string, Component: Function, props: Record<string, any> }>}
 */
export function visibleSections(sections, registry = defaultRegistry, warn = console.warn) {
    return asArray(sections).flatMap((section, index) => {
        if (! section || typeof section !== 'object') {
            return []
        }

        const props = section.props && typeof section.props === 'object' && ! Array.isArray(section.props) ? section.props : {}

        if (props.display === false || props.display === 'false') {
            return []
        }

        const name = sectionKey(section)
        const SectionComponent = Object.hasOwn(registry ?? {}, name) ? registry[name] : null

        if (! SectionComponent) {
            warn(`[site] The section "${name}" is not registered; it is not rendered.`)

            return []
        }

        return [{ key: `${index}-${name}`, name, group: String(section.group ?? ''), Component: SectionComponent, props }]
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

/**
 * Una sección que falla no se lleva la página entera: el resto se sigue
 * viendo y el error queda en consola.
 */
class SectionBoundary extends Component {
    state = { failed: false }

    static getDerivedStateFromError() {
        return { failed: true }
    }

    componentDidCatch(error) {
        console.error(`[site] The section "${this.props.name}" failed to render.`, error)
    }

    render() {
        return this.state.failed ? null : this.props.children
    }
}

const renderItem = ({ key, name, Component: SectionComponent, props }) => (
    <SectionBoundary key={key} name={name}>
        <SectionComponent props={props} />
    </SectionBoundary>
)

export default function ThemeManager({ sections = [], registry = defaultRegistry }) {
    const parts = useMemo(() => splitLandmarks(visibleSections(sections, registry)), [sections, registry])

    return (
        <>
            {parts.before.map(renderItem)}

            <main id="content" className="site-main">
                {parts.main.map(renderItem)}
            </main>

            {parts.after.map(renderItem)}
        </>
    )
}
