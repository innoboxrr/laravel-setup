import * as middleware from '@router/middleware'
import { dynamicRouteImport } from '@router/routes/dynamicRouteImport'
import { loadLayout } from '@js/loadLayout.js'

let modelRoutes = dynamicRouteImport(import.meta.globEager('/resources/vue/app/sections/admin/models/**/routes/index.js'));
let layoutComponent = loadLayout(import.meta.globEager('/resources/vue/app/sections/admin/layouts/**/layout.js'), import.meta.env.VITE_ADMIN_LAYOUT || 'default');

export default [
	{
		path: '/admin',
		name: "Admin",
        redirect: { name: "AdminStart" },
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
