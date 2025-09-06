import { dynamicRouteImport } from '@router/routes/dynamicRouteImport'

let routes = dynamicRouteImport(import.meta.glob('/resources/vue/app/sections/*/routes/index.js', { eager: true }));

export { routes }