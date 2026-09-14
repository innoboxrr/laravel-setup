import { useId, useState } from 'react'
import t from 'innoboxrr-i18n'

import { asArray, asObject, asText, Checklist, isOn, SectionHeader, SmartLink } from '../../shared.jsx'

/**
 * @param {{ props: { title?: string, subtitle?: string, frequencies?: Array<{value: string, label: string, price_suffix?: string}>, tiers?: Array<{id?: string, name: string, href?: string, description?: string, price?: Record<string, string>, features?: string[], most_popular?: boolean}> } }} props
 */
export default function PlansSection({ props = {} }) {
    const uid = useId()
    const frequencies = asArray(props.frequencies).filter((frequency) => asText(frequency?.value) !== '')
    const tiers = asArray(props.tiers).filter((tier) => tier && typeof tier === 'object')

    const [selected, setSelected] = useState(null)
    const current = frequencies.find((frequency) => frequency.value === selected) ?? frequencies[0] ?? null

    const priceOf = (tier) => {
        if (typeof tier.price === 'string' || typeof tier.price === 'number') {
            return asText(tier.price)
        }

        return current ? asText(asObject(tier.price)[current.value]) : ''
    }

    return (
        <section className="site-section">
            <div className="site-container">
                <SectionHeader title={props.title} subtitle={props.subtitle} />

                {frequencies.length > 1 ? (
                    <div className="site-segmented-wrap">
                        <fieldset className="site-segmented">
                            <legend className="app-sr-only">{t('Payment frequency')}</legend>

                            {frequencies.map((frequency) => (
                                <label key={frequency.value}>
                                    <input
                                        type="radio"
                                        name={`${uid}-frequency`}
                                        value={frequency.value}
                                        checked={current?.value === frequency.value}
                                        onChange={() => setSelected(frequency.value)} />
                                    <span>{asText(frequency.label) || frequency.value}</span>
                                </label>
                            ))}
                        </fieldset>
                    </div>
                ) : null}

                {tiers.length > 0 ? (
                    <div className="site-tiers">
                        {tiers.map((tier, index) => {
                            const headingId = `${uid}-tier-${index}`
                            const popular = isOn(tier.most_popular)
                            const price = priceOf(tier)
                            const suffix = asText(current?.price_suffix)

                            return (
                                <article key={asText(tier.id) || index} className="site-tier" data-popular={popular ? 'true' : 'false'} aria-labelledby={headingId}>
                                    <header className="site-tier-head">
                                        <h3 id={headingId} className="site-tier-name">{asText(tier.name)}</h3>
                                        {popular ? <span className="fe-badge fe-badge-primary">{t('Most popular')}</span> : null}
                                    </header>

                                    {asText(tier.description) !== '' ? <p className="site-body">{asText(tier.description)}</p> : null}

                                    {price !== '' ? (
                                        <p className="site-tier-price">
                                            <span className="site-tier-amount">{price}</span>
                                            {suffix !== '' ? <span className="site-tier-suffix">{suffix}</span> : null}
                                        </p>
                                    ) : null}

                                    {asText(tier.href) !== '' ? (
                                        <SmartLink href={tier.href} className={popular ? 'fe-button' : 'fe-button-secondary'} aria-describedby={headingId}>
                                            {t('Choose plan')}
                                        </SmartLink>
                                    ) : null}

                                    <Checklist items={tier.features} />
                                </article>
                            )
                        })}
                    </div>
                ) : null}
            </div>
        </section>
    )
}
