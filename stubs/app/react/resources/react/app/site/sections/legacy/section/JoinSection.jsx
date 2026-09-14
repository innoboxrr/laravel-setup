import { asText, Checklist, OptionalImage, SmartLink } from '../../shared.jsx'

/**
 * @param {{ props: { title?: string, subtitle?: string, image?: string, features?: string[], button_text?: string, button_link?: string } }} props
 */
export default function JoinSection({ props = {} }) {
    const title = asText(props.title)
    const subtitle = asText(props.subtitle)
    const button = asText(props.button_text)
    const hasImage = asText(props.image) !== ''

    return (
        <section className="site-section">
            <div className="site-container">
                <div className="site-join-card" data-media={hasImage ? 'true' : 'false'}>
                    <OptionalImage src={props.image} className="site-join-image" />

                    <div>
                        {title !== '' ? <h2 className="site-heading">{title}</h2> : null}
                        {subtitle !== '' ? <p className="site-lead">{subtitle}</p> : null}

                        <Checklist items={props.features} columns={2} />

                        {button !== '' ? (
                            <div className="site-actions">
                                <SmartLink href={props.button_link} className="fe-button site-button-lg">
                                    {button} <span aria-hidden="true">→</span>
                                </SmartLink>
                            </div>
                        ) : null}
                    </div>
                </div>
            </div>
        </section>
    )
}
