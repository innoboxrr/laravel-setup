import { HeroCopy } from '../../shared.jsx'

/**
 * Los de HeroOne sin `videos`. El original traía una foto fija de un banco de
 * imágenes que ninguna prop cambiaba; aquí es un dibujo con los colores del
 * tema, que sigue al modo oscuro.
 */
export default function HeroThree({ props = {} }) {
    return (
        <section className="site-hero site-hero-three">
            <div className="site-container site-hero-grid" data-media="true">
                <HeroCopy props={props} />

                <div className="site-hero-art" aria-hidden="true">
                    {Array.from({ length: 12 }, (_, index) => <span key={index} />)}
                </div>
            </div>
        </section>
    )
}
