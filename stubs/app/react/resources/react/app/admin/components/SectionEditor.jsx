import t from 'innoboxrr-i18n'
import { IconComponent } from 'innoboxrr-react-form-elements'

import sections, { sectionKey } from '../../site/sections/index.js'
import { isDisplayed, parseProps, setDisplay } from '../siteEditor.js'
import JsonEditor from './JsonEditor.jsx'

/**
 * Una sección de una página en el editor: visible o no, subir, bajar, quitar y
 * sus props en JSON.
 */
export default function SectionEditor({ section, index, total, onChange, onMove, onRemove }) {
    const parsed = parseProps(section.text)
    const known = Boolean(sections[sectionKey(section)])
    const visible = parsed.props ? isDisplayed(parsed.props) : true
    const name = section.name || t('Unnamed section')
    const editorId = `section-editor-${section.uid}`

    return (
        <li className="fe-card app-section-row" data-visible={visible ? 'true' : 'false'}>
            <div className="app-section-head">
                <span className="app-section-index" aria-hidden="true">{index + 1}</span>

                <div className="app-section-name">
                    <strong>{name}</strong>
                    <span className="app-section-meta">
                        {section.theme}/{section.group}
                        {known ? null : <span className="fe-badge fe-badge-warning">{t('Unknown')}</span>}
                        {parsed.error ? <span className="fe-badge fe-badge-danger">{t('Invalid JSON')}</span> : null}
                    </span>
                </div>

                <label className="app-toggle">
                    <input
                        type="checkbox"
                        role="switch"
                        className="fe-checkbox"
                        checked={visible}
                        disabled={! parsed.props}
                        aria-label={t('Show :name', { name })}
                        onChange={(event) => onChange({ text: setDisplay(section.text, event.target.checked) })} />
                    <span aria-hidden="true">{t('Visible')}</span>
                </label>

                <div className="app-section-actions">
                    <button type="button" className="fe-icon-button" aria-label={t('Move :name up', { name })} disabled={index === 0} onClick={() => onMove(-1)}>
                        <IconComponent name="up" size={14} />
                    </button>

                    <button type="button" className="fe-icon-button" aria-label={t('Move :name down', { name })} disabled={index === total - 1} onClick={() => onMove(1)}>
                        <IconComponent name="down" size={14} />
                    </button>

                    <button
                        type="button"
                        className="fe-button-secondary fe-button-sm"
                        aria-expanded={section.open}
                        aria-controls={editorId}
                        onClick={() => onChange({ open: ! section.open })}>
                        <IconComponent name="edit" size={12} />
                        {t('Edit props')}
                    </button>

                    <button type="button" className="fe-icon-button fe-icon-button-danger" aria-label={t('Remove :name', { name })} onClick={onRemove}>
                        <IconComponent name="delete" size={14} />
                    </button>
                </div>
            </div>

            {section.open ? (
                <div id={editorId} className="app-section-editor">
                    <JsonEditor
                        id={editorId}
                        label={t('Props of :name', { name })}
                        value={section.text}
                        invalid={Boolean(parsed.error)}
                        onChange={(text) => onChange({ text })} />

                    {parsed.error ? <p className="fe-error" role="alert">{t('Invalid JSON: :message', { message: parsed.error })}</p> : null}
                </div>
            ) : null}
        </li>
    )
}
