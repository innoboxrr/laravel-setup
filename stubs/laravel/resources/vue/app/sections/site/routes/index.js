import { dynamicRouteImport } from '@router/routes/dynamicRouteImport'

let pagesRoutes = await dynamicRouteImport(import.meta.glob('/resources/vue/app/sections/site/pages/**/routes/index.js'));

export default [

	{
		path: '/',
		name: "Site",
		component: () => import(/* webpackChunkName: "SiteLayout"*/ "./../layouts/default/SiteLayout.vue"),
		meta: {
			title: "Sitio",
		},
		children: [

			...pagesRoutes,

		]
	}
	
];