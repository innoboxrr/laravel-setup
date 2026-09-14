import { markRaw } from 'vue'

import CookieConsentOne from './legacy/cookie-consent/CookieConsentOne.vue'
import FooterOne from './legacy/footer/FooterOne.vue'
import HeaderOne from './legacy/header/HeaderOne.vue'
import HeroOne from './legacy/hero/HeroOne.vue'
import HeroThree from './legacy/hero/HeroThree.vue'
import HeroTwo from './legacy/hero/HeroTwo.vue'
import FaqSection from './legacy/section/FaqSection.vue'
import HtmlContent from './legacy/section/HtmlContent.vue'
import JoinSection from './legacy/section/JoinSection.vue'
import MissionSection from './legacy/section/MissionSection.vue'
import PartnersSection from './legacy/section/PartnersSection.vue'
import PlansSection from './legacy/section/PlansSection.vue'
import TestimonialsSection from './legacy/section/TestimonialsSection.vue'

/**
 * Las secciones del sitio, por `<theme>/<group>/<name>`: la misma clave que
 * guarda cada sección en la opción `theme`. Una sección nueva se registra aquí.
 */
const sections = {
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

// Son definiciones de componente, no estado: markRaw evita que Vue las haga
// reactivas al pasar por una prop o un computed.
for (const key of Object.keys(sections)) {
    sections[key] = markRaw(sections[key])
}

export default sections
