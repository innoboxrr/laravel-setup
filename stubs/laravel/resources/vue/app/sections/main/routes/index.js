import { dynamicRouteImport } from '@router/routes/dynamicRouteImport'
import { loadLayout } from '@js/loadLayout.js'

let pagesRoutes = dynamicRouteImport(import.meta.globEager('/resources/vue/app/sections/main/pages/**/routes/index.js'));
let layoutComponent = loadLayout(import.meta.globEager('/resources/vue/app/sections/main/layouts/**/layout.js'), import.meta.env.VITE_APP_LAYOUT || 'default');

export default [
	{
		path: '/app',
		name: "App",
		component: layoutComponent,
		meta: {
			title: "App",
		},
		children: [
			...pagesRoutes
		]
	}
];