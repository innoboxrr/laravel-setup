import { useState } from 'react'

import { asArray, asText, SectionHeader, SmartLink } from '../../shared.jsx'

function PartnerLogo({ partner }) {
    const [broken, setBroken] = useState(false)
    const logo = asText(partner.logo)
    const name = asText(partner.name)

    // Sin logo, o si no carga, el nombre ocupa su sitio.
    return logo !== '' && ! broken
        ? <img src={logo} alt={name} loading="lazy" onError={() => setBroken(true)} />
        : <span>{name}</span>
}

/**
 * @param {{ props: { title?: string, items?: Array<{name: string, logo?: string, link?: string}> } }} props
 */
export default function PartnersSection({ props = {} }) {
    const items = asArray(props.items).filter((item) => asText(item?.name) !== '' || asText(item?.logo) !== '')

    return (
        <section className="site-section site-section-alt">
            <div className="site-container">
                <SectionHeader title={props.title} />

                {items.length > 0 ? (
                    <ul className="site-partners">
                        {items.map((partner, index) => (
                            <li key={`${index}-${partner.name}`}>
                                <SmartLink href={partner.link} className="site-partner">
                                    <PartnerLogo partner={partner} />
                                </SmartLink>
                            </li>
                        ))}
                    </ul>
                ) : null}
            </div>
        </section>
    )
}
