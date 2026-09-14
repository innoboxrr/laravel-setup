import { asArray, asText, OptionalImage, SmartLink } from '../../shared.jsx'

/**
 * @param {{ props: { title?: string, subtitle?: string, message?: string, button_text?: string, button_link?: string, images?: string[] } }} props
 */
export default function MissionSection({ props = {} }) {
    const images = asArray(props.images).map(asText).filter((src) => src !== '').slice(0, 4)
    const title = asText(props.title)
    const subtitle = asText(props.subtitle)
    const message = asText(props.message)
    const button = asText(props.button_text)

    return (
        <section className="site-section site-section-alt">
            <div className="site-container site-split" data-media={images.length > 0 ? 'true' : 'false'}>
                <div className="site-mission-copy">
                    {title !== '' ? <h2 className="site-heading">{title}</h2> : null}
                    {subtitle !== '' ? <p className="site-lead">{subtitle}</p> : null}
                    {message !== '' ? <p className="site-body">{message}</p> : null}

                    {button !== '' ? (
                        <div className="site-actions">
                            <SmartLink href={props.button_link} className="fe-button site-button-lg">
                                {button} <span aria-hidden="true">→</span>
                            </SmartLink>
                        </div>
                    ) : null}
                </div>

                {images.length > 0 ? (
                    <div className="site-mosaic" data-count={images.length}>
                        {images.map((src, index) => <OptionalImage key={`${index}-${src}`} src={src} className="site-mosaic-img" />)}
                    </div>
                ) : null}
            </div>
        </section>
    )
}
