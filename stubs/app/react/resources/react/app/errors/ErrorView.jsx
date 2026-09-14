import { useRouteError } from 'react-router-dom'
import t from 'innoboxrr-i18n'

/**
 * Lo que se ve si una pantalla falla al cargar —un chunk que ya no existe tras
 * un despliegue, por ejemplo— en lugar de la página en blanco.
 */
export default function ErrorView() {
    const error = useRouteError()

    console.error(error)

    return (
        <main className="app-error">
            <h1 className="app-error-title">{t('Something went wrong')}</h1>

            <p className="app-error-text">{t('Reload the page. If it keeps happening, contact the administrator.')}</p>

            <div className="app-error-actions">
                <button type="button" className="fe-button" onClick={() => window.location.reload()}>{t('Reload')}</button>

                <a href="/" className="fe-button-secondary">{t('Go to the home page')}</a>
            </div>
        </main>
    )
}
