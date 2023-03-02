import * as middleware from '@router/middleware'
// Importar rutas de error

export default [

	{
		path: '/error',
		name: "Error",
		component: () => import(/* webpackChunkName: "ErrorLayout"*/ "@layouts/error/ErrorLayout.vue"),
		meta: {
			title: "Error",
		},
		children: [

			// ...importedRoute,

		]
	}
	
];