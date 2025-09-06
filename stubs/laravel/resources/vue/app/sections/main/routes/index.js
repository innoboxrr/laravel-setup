import { dynamicRouteImport } from '@router/routes/dynamicRouteImport'
import { loadLayout } from '@js/loadLayout.js'

let pagesRoutes = dynamicRouteImport(import.meta.glob('/resources/vue/app/sections/main/pages/**/routes/index.js', { eager: true }));
let layoutComponent = loadLayout(import.meta.glob('/resources/vue/app/sections/main/layouts/**/layout.js', { eager: true }), import.meta.env.VITE_APP_LAYOUT || 'default');

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