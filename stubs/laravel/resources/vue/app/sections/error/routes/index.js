import { dynamicRouteImport } from '@router/routes/dynamicRouteImport'

let pagesRoutes = await dynamicRouteImport(import.meta.glob('/resources/vue/app/sections/error/pages/**/routes/index.js'));

export default [

	{
		path: '/error',
		name: "Error",
		component: () => import(/* webpackChunkName: "ErrorLayout"*/ "./../layouts/default/ErrorLayout.vue"),
		meta: {
			title: "Error",
		},
		children: [

			...pagesRoutes,

		]
	}
	
];