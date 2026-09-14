import { safeHref } from '../links.js'
import { asObject } from './props.js'

const NETWORKS = [
    ['facebook', 'Facebook', 'fa6-brands:facebook'],
    ['instagram', 'Instagram', 'fa6-brands:instagram'],
    ['twitter', 'X', 'fa6-brands:x-twitter'],
    ['linkedin', 'LinkedIn', 'fa6-brands:linkedin'],
    ['youtube', 'YouTube', 'fa6-brands:youtube'],
    ['tiktok', 'TikTok', 'fa6-brands:tiktok'],
    ['whatsapp', 'WhatsApp', 'fa6-brands:whatsapp'],
    ['github', 'GitHub', 'fa6-brands:github'],
]

/**
 * Las redes que tienen enlace, en un orden fijo.
 */
export function socialLinks(source) {
    const links = asObject(source)

    return NETWORKS.flatMap(([id, label, icon]) => {
        const href = safeHref(links[id])

        return href ? [{ id, label, icon, href }] : []
    })
}
