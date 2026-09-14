import { useState } from 'react'

import { asArray, asObject, asText, SectionHeader } from '../../shared.jsx'

const initials = (name) => asText(name).split(/\s+/).filter(Boolean).slice(0, 2).map((word) => word[0].toUpperCase()).join('')

/**
 * Un testimonio en la forma que pinta la sección, o null si no tiene texto.
 * `message` era el nombre de la clave en las aplicaciones antiguas.
 */
export function normalizeTestimonial(value, featured = false) {
    const item = asObject(value)
    const author = asObject(item.author)
    const body = asText(item.body ?? item.message)

    if (body.trim() === '') {
        return null
    }

    return {
        featured,
        body,
        name: asText(author.name),
        handle: asText(author.handle),
        image: asText(author.image).trim(),
    }
}

function Author({ entry }) {
    const [broken, setBroken] = useState(false)

    if (entry.name === '' && entry.handle === '') {
        return null
    }

    return (
        <figcaption className="site-author">
            {entry.image !== '' && ! broken
                ? <img className="site-author-avatar" src={entry.image} alt="" loading="lazy" onError={() => setBroken(true)} />
                : <span className="site-author-avatar" aria-hidden="true">{initials(entry.name)}</span>}

            <span>
                {entry.name !== '' ? <span className="site-author-name">{entry.name}</span> : null}
                {entry.handle !== '' ? <span className="site-author-handle">{entry.handle}</span> : null}
            </span>
        </figcaption>
    )
}

/**
 * @param {{ props: { title?: string, subtitle?: string, feature?: {body: string, author: {name: string, handle: string, image?: string}}, items?: Array<{body: string, author: {name: string, handle: string, image?: string}}> } }} props
 */
export default function TestimonialsSection({ props = {} }) {
    const featured = normalizeTestimonial(props.feature, true)
    const entries = asArray(props.items).map((item) => normalizeTestimonial(item)).filter(Boolean)
    const all = featured ? [featured, ...entries] : entries

    return (
        <section className="site-section site-section-alt">
            <div className="site-container">
                <SectionHeader title={props.title} subtitle={props.subtitle} />

                {all.length > 0 ? (
                    <div className="site-testimonials">
                        {all.map((entry, index) => (
                            <figure key={index} className={entry.featured ? 'site-quote site-quote-featured' : 'site-quote'}>
                                <blockquote>
                                    <p>“{entry.body}”</p>
                                </blockquote>

                                <Author entry={entry} />
                            </figure>
                        ))}
                    </div>
                ) : null}
            </div>
        </section>
    )
}
