import { dynamicRouteImport } from '@router/routes/dynamicRouteImport'

let pagesRoutes = dynamicRouteImport(import.meta.globEager('/resources/vue/app/sections/auth/pages/**/routes/index.js'));

export default [

	{
		path: '/auth',
		name: "Auth",
		redirect: { name: 'Login'},
		component: () => import(/* webpackChunkName: "AuthLayout"*/ "./../layouts/default/AuthLayout.vue"),
		meta: {
			title: "Auth",
		},
		children: [

			...pagesRoutes,

		]
	}
	
];