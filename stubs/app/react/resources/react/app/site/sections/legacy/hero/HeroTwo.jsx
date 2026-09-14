import { useState } from 'react'
import t from 'innoboxrr-i18n'
import { DialogComponent, IconComponent } from 'innoboxrr-react-form-elements'

import { asArray, asText, HeroCopy, isOn, OptionalImage } from '../../shared.jsx'

/**
 * Los de HeroOne sin `videos`, más `badge_value_link`, `video`,
 * `display_play_button`, `play_button_text` e `imgs_1`, `imgs_2`, `imgs_3`.
 */
export default function HeroTwo({ props = {} }) {
    const [playing, setPlaying] = useState(false)

    const columns = [props.imgs_1, props.imgs_2, props.imgs_3]
        .map((list) => asArray(list).map(asText).map((src) => src.trim()).filter((src) => src !== ''))
        .filter((list) => list.length > 0)

    const hasImages = columns.length > 0
    const video = asText(props.video).trim()
    // El botón necesita las dos cosas: un vídeo y que se pida mostrarlo.
    const canPlay = video !== '' && isOn(props.display_play_button)
    const playText = asText(props.play_button_text).trim() || t('Play video')

    const playButton = (className) => (
        <button type="button" className={className} onClick={() => setPlaying(true)}>
            <IconComponent name="play" size={14} />
            <span>{playText}</span>
        </button>
    )

    return (
        <section className="site-hero site-hero-two">
            <div className="site-container site-hero-grid" data-media={hasImages ? 'true' : 'false'}>
                {/* Sin imágenes no hay galería donde poner el botón: va con los demás. */}
                <HeroCopy
                    props={props}
                    badgeValueLink={props.badge_value_link}
                    actions={canPlay && ! hasImages ? playButton('fe-button-secondary site-button-lg') : null} />

                {hasImages ? (
                    <div className="site-hero-gallery">
                        <div className="site-hero-columns" aria-hidden="true">
                            {columns.map((list, column) => (
                                // La lista va dos veces para que la animación
                                // dé la vuelta sin un salto.
                                <div key={column} className="site-hero-column" data-direction={column % 2 === 1 ? 'down' : 'up'}>
                                    {[...list, ...list].map((src, index) => (
                                        <OptionalImage key={`${index}-${src}`} src={src} className="site-hero-shot" />
                                    ))}
                                </div>
                            ))}
                        </div>

                        {canPlay ? playButton('site-play') : null}
                    </div>
                ) : null}
            </div>

            {canPlay ? (
                <DialogComponent open={playing} onOpenChange={setPlaying} title={playText} size="lg" closeLabel={t('Close')}>
                    {playing ? <video className="site-lightbox-video" src={video} controls autoPlay playsInline /> : null}
                </DialogComponent>
            ) : null}
        </section>
    )
}
