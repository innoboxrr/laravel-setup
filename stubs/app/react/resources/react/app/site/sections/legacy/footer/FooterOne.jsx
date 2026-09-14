import t from 'innoboxrr-i18n'

import { useSiteName } from '../../../../stores/options.js'
import { asArray, asObject, asText, Brand, SmartLink, SocialLinks } from '../../shared.jsx'

/**
 * @param {{ props: { logo?: string, description?: string, cols?: Array<{title: string, items: Array<{name: string, link: string}>}>, newsletter?: {title?: string, subtitle?: string, button_text?: string, button_link?: string}, social_links?: Record<string, string> } }} props
 */
export default function FooterOne({ props = {} }) {
    const siteName = useSiteName()
    const description = asText(props.description)
    const cols = asArray(props.cols).filter((col) => col && typeof col === 'object')
    const newsletter = asObject(props.newsletter)
    const cta = {
        title: asText(newsletter.title),
        subtitle: asText(newsletter.subtitle),
        button: asText(newsletter.button_text),
    }

    return (
        <footer className="site-footer">
            <div className="site-container">
                <div className="site-footer-top">
                    <div className="site-footer-brand">
                        <Brand logo={props.logo} name={siteName} />
                        {description !== '' ? <p>{description}</p> : null}
                    </div>

                    {cols.length > 0 ? (
                        <nav className="site-footer-cols" aria-label={t('Footer')}>
                            {cols.map((col, index) => (
                                <div key={`${index}-${col.title}`}>
                                    {asText(col.title) !== '' ? <h2 className="site-footer-title">{asText(col.title)}</h2> : null}

                                    <ul className="site-footer-links">
                                        {asArray(col.items).filter((item) => asText(item?.name) !== '').map((item, itemIndex) => (
                                            <li key={`${itemIndex}-${item.name}`}>
                                                <SmartLink href={item.link}>{asText(item.name)}</SmartLink>
                                            </li>
                                        ))}
                                    </ul>
                                </div>
                            ))}
                        </nav>
                    ) : null}
                </div>

                {cta.title !== '' || cta.subtitle !== '' || cta.button !== '' ? (
                    <div className="site-footer-cta">
                        <div>
                            {cta.title !== '' ? <h2 className="site-footer-cta-title">{cta.title}</h2> : null}
                            {cta.subtitle !== '' ? <p>{cta.subtitle}</p> : null}
                        </div>

                        {cta.button !== '' ? <SmartLink href={newsletter.button_link} className="fe-button">{cta.button}</SmartLink> : null}
                    </div>
                ) : null}

                <div className="site-footer-bottom">
                    <p>© {new Date().getFullYear()} {siteName}. {t('All rights reserved.')}</p>

                    <SocialLinks links={props.social_links} />
                </div>
            </div>
        </footer>
    )
}
