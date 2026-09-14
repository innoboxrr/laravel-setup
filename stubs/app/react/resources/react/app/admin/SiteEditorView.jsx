import { useId, useMemo, useRef, useState } from 'react'
import t from 'innoboxrr-i18n'
import { confirmAction, notifyError, notifySuccess } from 'innoboxrr-form-core'
import { IconComponent, TextareaInputComponent, TextInputComponent } from 'innoboxrr-react-form-elements'

import { sitePages } from '../config.js'
import { errorMessage } from '../forms/errors.js'
import sections, { parseSectionKey } from '../site/sections/index.js'
import { useOptionsStore } from '../stores/options.js'
import SectionEditor from './components/SectionEditor.jsx'
import { moveItem, toEditable, toEditableSection, toTheme } from './siteEditor.js'

const text = (value) => (typeof value === 'string' ? value : '')

/**
 * El editor del sitio: nombre, descripción y las secciones de cada página.
 * Todo se edita en un borrador y se escribe al guardar.
 */
export default function SiteEditorView() {
    const initial = useRef(useOptionsStore.getState().values)
    const save = useOptionsStore((state) => state.save)
    const uid = useId()

    const [siteName, setSiteName] = useState(() => text(initial.current.site_name))
    const [siteDescription, setSiteDescription] = useState(() => text(initial.current.site_description))
    const [pages, setPages] = useState(() => toEditable(initial.current.theme))
    const [active, setActive] = useState(() => Object.keys(pages)[0])
    const [toAdd, setToAdd] = useState(() => Object.keys(sections)[0])
    const [saving, setSaving] = useState(false)
    const [serverError, setServerError] = useState(null)

    const pageKeys = Object.keys(pages)
    const page = pages[active]
    const invalid = useMemo(() => toTheme(pages).invalid, [pages])
    const tabs = useRef({})

    const labelOf = (key) => {
        const known = sitePages.find((item) => item.key === key)

        return known ? t(known.label) : key
    }

    const urlOf = (key) => sitePages.find((item) => item.key === key)?.path ?? `/${key}`

    const updatePage = (key, change) => setPages((current) => ({ ...current, [key]: { ...current[key], ...change(current[key]) } }))

    const updateSection = (index, change) => updatePage(active, (current) => ({
        sections: current.sections.map((section, position) => (position === index ? { ...section, ...change } : section)),
    }))

    const moveSection = (index, offset) => updatePage(active, (current) => ({ sections: moveItem(current.sections, index, index + offset) }))

    const removeSection = async (index) => {
        const confirmed = await confirmAction({
            title: t('Remove section'),
            message: t('The section will be removed from this page when you save.'),
            confirmLabel: t('Remove'),
            cancelLabel: t('Cancel'),
            variant: 'danger',
        })

        if (confirmed) {
            updatePage(active, (current) => ({ sections: current.sections.filter((_, position) => position !== index) }))
        }
    }

    const addSection = () => {
        const section = { ...toEditableSection({ ...parseSectionKey(toAdd), props: { display: true } }), open: true }

        updatePage(active, (current) => ({ sections: [...current.sections, section] }))
    }

    const onTabKeyDown = (event, index) => {
        const moves = { ArrowRight: index + 1, ArrowLeft: index - 1, Home: 0, End: pageKeys.length - 1 }

        if (! (event.key in moves)) {
            return
        }

        event.preventDefault()

        const key = pageKeys[(moves[event.key] + pageKeys.length) % pageKeys.length]

        setActive(key)
        tabs.current[key]?.focus()
    }

    const submit = async () => {
        const { theme, invalid: broken } = toTheme(pages)

        if (broken.length > 0) {
            notifyError(t('Fix the invalid JSON before saving.'))

            return
        }

        setSaving(true)
        setServerError(null)

        try {
            // Nombre y descripción sólo si cambiaron: cada uno es una opción y
            // una petición.
            const saved = useOptionsStore.getState().values

            if (siteName !== text(saved.site_name)) {
                await save('site_name', siteName)
            }

            if (siteDescription !== text(saved.site_description)) {
                await save('site_description', siteDescription)
            }

            await save('theme', theme)

            notifySuccess(t('The site has been saved.'))
        } catch (error) {
            const fields = error?.response?.status === 422 ? error.response.data?.errors : null
            const message = fields && typeof fields === 'object' ? Object.values(fields).flat().join(' ') : errorMessage(error)

            setServerError(message)
            notifyError(message)
        } finally {
            setSaving(false)
        }
    }

    return (
        <div className="app-page">
            <header className="app-editor-bar">
                <div>
                    <h1 className="app-page-title">{t('Site')}</h1>
                    <p className="app-page-subtitle">{t('The name, the description and the sections of each page.')}</p>
                </div>

                <button type="button" className="fe-button" disabled={saving || invalid.length > 0} onClick={submit}>
                    <IconComponent name="save" size={14} />
                    {saving ? t('Saving…') : t('Save')}
                </button>
            </header>

            {invalid.length > 0 ? <p className="app-banner app-banner-danger" role="alert">{t('Some sections have invalid JSON. Fix them to save.')}</p> : null}

            {serverError ? <p className="app-banner app-banner-danger" role="alert">{serverError}</p> : null}

            <section className="fe-card" aria-labelledby={`${uid}-general`}>
                <div className="fe-card-body">
                    <h2 id={`${uid}-general`} className="app-section-title">{t('General')}</h2>

                    <TextInputComponent label={t('Site name')} name="site_name" type="text" value={siteName} onChange={setSiteName} />

                    <TextareaInputComponent label={t('Site description')} name="site_description" rows={2} value={siteDescription} onChange={setSiteDescription} />
                </div>
            </section>

            <section aria-labelledby={`${uid}-pages`}>
                <h2 id={`${uid}-pages`} className="app-sr-only">{t('Pages')}</h2>

                <div className="app-tabs" role="tablist" aria-label={t('Pages')}>
                    {pageKeys.map((key, index) => (
                        <button
                            key={key}
                            ref={(element) => { tabs.current[key] = element }}
                            type="button"
                            role="tab"
                            id={`${uid}-tab-${key}`}
                            className="app-tab"
                            aria-selected={active === key}
                            aria-controls={`${uid}-panel`}
                            tabIndex={active === key ? 0 : -1}
                            onKeyDown={(event) => onTabKeyDown(event, index)}
                            onClick={() => setActive(key)}>
                            {labelOf(key)}
                        </button>
                    ))}
                </div>

                {page ? (
                    <div id={`${uid}-panel`} role="tabpanel" aria-labelledby={`${uid}-tab-${active}`} className="app-tabpanel">
                        <div className="app-page-tools">
                            <TextInputComponent
                                key={active}
                                label={t('Page title')}
                                name={`title_${active}`}
                                type="text"
                                value={page.title}
                                onChange={(title) => updatePage(active, () => ({ title }))} />

                            <a href={urlOf(active)} target="_blank" rel="noopener noreferrer" className="fe-button-secondary">
                                <IconComponent name="external" size={12} />
                                {t('View page')}
                                <span className="app-sr-only">{t('(opens in a new tab)')}</span>
                            </a>
                        </div>

                        {page.sections.length === 0 ? <p className="fe-text-muted">{t('This page has no sections yet.')}</p> : (
                            <ol className="app-section-list">
                                {page.sections.map((section, index) => (
                                    <SectionEditor
                                        key={section.uid}
                                        section={section}
                                        index={index}
                                        total={page.sections.length}
                                        onChange={(change) => updateSection(index, change)}
                                        onMove={(offset) => moveSection(index, offset)}
                                        onRemove={() => removeSection(index)} />
                                ))}
                            </ol>
                        )}

                        <div className="app-add-section">
                            <label htmlFor={`${uid}-add`} className="fe-label">{t('Add a section')}</label>

                            <div className="app-inline">
                                <select id={`${uid}-add`} className="fe-select" value={toAdd} onChange={(event) => setToAdd(event.target.value)}>
                                    {Object.keys(sections).map((key) => {
                                        const { group, name } = parseSectionKey(key)

                                        return <option key={key} value={key}>{`${name} (${group})`}</option>
                                    })}
                                </select>

                                <button type="button" className="fe-button-secondary" onClick={addSection}>
                                    <IconComponent name="plus" size={12} />
                                    {t('Add')}
                                </button>
                            </div>
                        </div>
                    </div>
                ) : null}
            </section>
        </div>
    )
}
