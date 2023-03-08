import { dynamicRouteImport } from '@router/routes/dynamicRouteImport'

let routes = await dynamicRouteImport(import.meta.glob('/resources/vue/app/sections/*/routes/index.js'));

export { routes }