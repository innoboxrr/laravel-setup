import { useMemo } from 'react'

import { asArray, asText, HeroCopy } from '../../shared.jsx'

/**
 * @param {{ props: { badge?: string, badge_value?: string, badge_link?: string, title?: string, message?: string, primary_button_text?: string, primary_button_link?: string, secondary_button_text?: string, secondary_button_link?: string, videos?: string[] } }} props
 */
export default function HeroOne({ props = {} }) {
    const videos = asArray(props.videos).map(asText).filter((video) => video !== '')
    const signature = videos.join('|')

    // Uno al azar por visita, estable mientras la lista no cambie: depende de
    // su contenido y no del arreglo, que es nuevo en cada render.
    const video = useMemo(() => {
        const list = signature === '' ? [] : signature.split('|')

        return list.length > 0 ? list[Math.floor(Math.random() * list.length)] : null
    }, [signature])

    return (
        <section className="site-hero">
            <div className="site-container site-hero-grid" data-media={video ? 'true' : 'false'}>
                <HeroCopy props={props} />

                {video ? (
                    <div className="site-hero-media">
                        <video className="site-hero-video" src={video} autoPlay muted loop playsInline aria-hidden="true" />
                    </div>
                ) : null}
            </div>
        </section>
    )
}
