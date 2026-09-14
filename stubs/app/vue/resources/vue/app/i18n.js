import { addTranslations, setLocale } from 'innoboxrr-i18n'

/**
 * Los textos: primero los del módulo de LaraPack y después los de la
 * aplicación, que ganan si repiten una clave.
 *
 * innoboxrr-i18n no es reactivo, así que el idioma se fija una vez, antes de
 * montar: cambiarlo después no repintaría lo que ya está en pantalla.
 */
export function setupI18n(moduleTranslations = {}, locale = document.documentElement.lang) {
    addTranslations(moduleTranslations)
    addTranslations(import.meta.glob('./lang/*.json', { eager: true }))

    setLocale(locale || 'en')
}
