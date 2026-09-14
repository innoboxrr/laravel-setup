import { asArray, asText, SectionHeader } from '../../shared.jsx'

/**
 * @param {{ props: { title?: string, subtitle?: string, items?: Array<{question: string, answer: string}> } }} props
 */
export default function FaqSection({ props = {} }) {
    const items = asArray(props.items).filter((item) => asText(item?.question) !== '')

    return (
        <section className="site-section">
            <div className="site-container">
                <SectionHeader title={props.title} subtitle={props.subtitle} />

                {items.length > 0 ? (
                    <dl className="site-faq">
                        {items.map((item, index) => (
                            <div key={`${index}-${item.question}`} className="site-faq-item">
                                <dt>{asText(item.question)}</dt>
                                <dd>{asText(item.answer)}</dd>
                            </div>
                        ))}
                    </dl>
                ) : null}
            </div>
        </section>
    )
}
