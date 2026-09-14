import { addTranslations, setLocale } from 'innoboxrr-i18n'

const appTranslations = import.meta.glob('./lang/*.json', { eager: true })

/**
 * innoboxrr-i18n no es reactivo: el idioma se fija una vez, antes de pintar.
 * Las traducciones de la aplicación se cargan después de las del módulo para
 * que, si comparten una clave, gane la de la aplicación.
 *
 * @param {Record<string, Record<string, string>>} moduleTranslations
 */
export function setupI18n(moduleTranslations = {}) {
    addTranslations(moduleTranslations)
    addTranslations(appTranslations)

    setLocale(document.documentElement.lang || 'en')
}
