/**
 * El módulo que genera LaraPack en resources/vue/index.js.
 *
 * Se carga con un glob y no con un import fijo para que la aplicación compile
 * también antes de generar el primer modelo: sin módulo, no hay rutas que
 * añadir y el menú sólo tiene lo propio.
 */

const found = Object.values(import.meta.glob('../index.js', { eager: true }))[0] ?? {}

export const moduleRoutes = Array.isArray(found.routes) ? found.routes : []

export const moduleTranslations = found.translations ?? {}

export const modulePlugin = found.default ?? null
