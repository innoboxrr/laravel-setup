/**
 * Las secciones que puede pintar el sitio, por `<theme>/<group>/<name>`: la
 * forma en que las nombra la opción `theme`. Una sección nueva se añade aquí y
 * aparece también en el editor del sitio.
 */

import CookieConsentOne from './legacy/cookie-consent/CookieConsentOne.jsx'
import FooterOne from './legacy/footer/FooterOne.jsx'
import HeaderOne from './legacy/header/HeaderOne.jsx'
import HeroOne from './legacy/hero/HeroOne.jsx'
import HeroThree from './legacy/hero/HeroThree.jsx'
import HeroTwo from './legacy/hero/HeroTwo.jsx'
import FaqSection from './legacy/section/FaqSection.jsx'
import HtmlContent from './legacy/section/HtmlContent.jsx'
import JoinSection from './legacy/section/JoinSection.jsx'
import MissionSection from './legacy/section/MissionSection.jsx'
import PartnersSection from './legacy/section/PartnersSection.jsx'
import PlansSection from './legacy/section/PlansSection.jsx'
import TestimonialsSection from './legacy/section/TestimonialsSection.jsx'

export const sections = {
    'legacy/header/HeaderOne': HeaderOne,
    'legacy/hero/HeroOne': HeroOne,
    'legacy/hero/HeroTwo': HeroTwo,
    'legacy/hero/HeroThree': HeroThree,
    'legacy/section/MissionSection': MissionSection,
    'legacy/section/JoinSection': JoinSection,
    'legacy/section/FaqSection': FaqSection,
    'legacy/section/PartnersSection': PartnersSection,
    'legacy/section/TestimonialsSection': TestimonialsSection,
    'legacy/section/PlansSection': PlansSection,
    'legacy/section/HtmlContent': HtmlContent,
    'legacy/footer/FooterOne': FooterOne,
    'legacy/cookie-consent/CookieConsentOne': CookieConsentOne,
}

export const sectionKey = (section) => `${section?.theme ?? ''}/${section?.group ?? ''}/${section?.name ?? ''}`

/** `legacy/hero/HeroOne` → `{ theme: 'legacy', group: 'hero', name: 'HeroOne' }` */
export function parseSectionKey(key) {
    const [theme = '', group = '', name = ''] = String(key).split('/')

    return { theme, group, name }
}

export default sections
