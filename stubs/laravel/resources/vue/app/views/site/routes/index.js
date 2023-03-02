import * as middleware from '@router/middleware'
// Importar rutas del sitio

export default [

	{
		path: '/',
		name: "Site",
		component: () => import(/* webpackChunkName: "SiteLayout"*/ "@layouts/site/SiteLayout.vue"),
		meta: {
			title: "Sitio",
		},
		children: [

			// ...importedRoute,

		]

	}
	
];