import { dynamicRouteImport } from '@router/routes/dynamicRouteImport'

let pagesRoutes = dynamicRouteImport(import.meta.globEager('/resources/vue/app/sections/lms/pages/**/routes/index.js'));

export default [

	{
		path: '/lms',
		name: "Lms",
		component: () => import(/* webpackChunkName: "LmsLayout"*/ "./../layouts/default/LmsLayout.vue"),
		meta: {
			title: "LMS",
		},
		children: [
			
			...pagesRoutes,

		]
	}
	
];