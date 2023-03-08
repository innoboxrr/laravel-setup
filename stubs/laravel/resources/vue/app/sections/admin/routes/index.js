import { dynamicRouteImport } from '@router/routes/dynamicRouteImport'

let modelRoutes = await dynamicRouteImport(import.meta.glob('/resources/vue/app/sections/admin/models/**/routes/index.js'));

let pagesRoutes = await dynamicRouteImport(import.meta.glob('/resources/vue/app/sections/admin/pages/**/routes/index.js'));

export default [

	{
		path: '/admin',
		name: "Admin",
		component: () => import(/* webpackChunkName: "AdminLayout"*/ "./../layouts/default/AdminLayout.vue"),
		meta: {
			title: "Administración",
		},
		children: [

			...modelRoutes,

			...pagesRoutes

		]
	}
	
];