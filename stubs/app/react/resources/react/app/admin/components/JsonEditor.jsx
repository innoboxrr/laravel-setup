import { CodeMirrorComponent } from 'innoboxrr-react-form-elements'

import { useIsDark } from '../../stores/ui.js'

/**
 * El editor de las props de una sección: CodeMirror en modo JSON, con el tema
 * que siga al modo oscuro de la aplicación.
 */
export default function JsonEditor({ id, label, value, invalid = false, onChange }) {
    const dark = useIsDark()

    return (
        <div className="app-json" data-invalid={invalid ? 'true' : 'false'}>
            <CodeMirrorComponent
                label={label}
                name={id}
                language="json"
                height="16rem"
                theme={dark ? 'dark' : 'light'}
                value={value}
                onChange={onChange}
                aria-label={label} />
        </div>
    )
}
