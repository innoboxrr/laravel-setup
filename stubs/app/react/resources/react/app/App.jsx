import { RouterProvider } from 'react-router-dom'
import t from 'innoboxrr-i18n'
import { ConfirmHostComponent, ToastRegionComponent } from 'innoboxrr-react-form-elements'

/**
 * Los avisos y la confirmación se montan una sola vez, aquí: cualquier pieza
 * —la aplicación, el módulo de LaraPack, la tabla— los pide con notify() y
 * confirmAction() sin saber dónde se pintan.
 */
export default function App({ router }) {
    return (
        <>
            <RouterProvider router={router} />

            <ToastRegionComponent label={t('Alerts')} closeLabel={t('Close')} />

            <ConfirmHostComponent closeLabel={t('Close')} />
        </>
    )
}
