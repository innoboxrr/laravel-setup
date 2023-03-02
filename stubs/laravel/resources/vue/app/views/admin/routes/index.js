import * as middleware from '@router/middleware'
// Importar las rutas de administración

export default [

	{
		path: '/admin',
		name: "Admin",
		component: () => import(/* webpackChunkName: "AdminLayout"*/ "@layouts/admin/AdminLayout.vue"),
		meta: {
			title: "Administración",
		},
		children: [

			// ...importedRoute,

		]
	}
	
];