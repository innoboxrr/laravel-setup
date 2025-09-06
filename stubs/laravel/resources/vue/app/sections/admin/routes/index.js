import * as middleware from '@router/middleware'
import { dynamicRouteImport } from '@router/routes/dynamicRouteImport'
import { loadLayout } from '@js/loadLayout.js'

let modelRoutes = dynamicRouteImport(import.meta.glob('/resources/vue/app/sections/admin/models/**/routes/index.js', { eager: true }));
let layoutComponent = loadLayout(import.meta.glob('/resources/vue/app/sections/admin/layouts/**/layout.js', { eager: true }), import.meta.env.VITE_ADMIN_LAYOUT || 'default');

export default [
	{
		path: '/admin',
		name: "Admin",
		component: layoutComponent,
		meta: {
			title: "Administration",
			middleware: [
				middleware.admin
			]
		},
		children: [
			...modelRoutes,
		]
	}
];
