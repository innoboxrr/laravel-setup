import { asText } from '../../shared.jsx'

/**
 * `content` es HTML que escribe quien administra, y se pinta como tal: el
 * editor del sitio sólo lo puede guardar un administrador.
 *
 * @param {{ props: { content?: string } }} props
 */
export default function HtmlContent({ props = {} }) {
    const content = asText(props.content)

    if (content === '') {
        return null
    }

    return (
        <section className="site-section">
            <div className="site-container">
                <div className="site-prose" dangerouslySetInnerHTML={{ __html: content }} />
            </div>
        </section>
    )
}
