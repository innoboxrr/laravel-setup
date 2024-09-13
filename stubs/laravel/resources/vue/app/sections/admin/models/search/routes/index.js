import * as middleware from '@router/middleware'

export default [
	{
		path: 'search',
		name: "AdminSearches",
		component: () => import ("./../views/AdminView.vue"),
		meta: {
			title: 'Searches',
			middleware: [
				middleware.auth
			]
		},
		children: [
			{
				path: 'create',
				name: "AdminCreateSearch",
				component: () => import ("./../views/CreateView.vue"),
				meta: {
					title: 'Crear Searches',
					middleware: [
						middleware.auth
					]
				}
			},
			{
				path: ':id',
				name: "AdminShowSearch",
				component: () => import ("./../views/ShowView.vue"),
				meta: {
					title: 'Ver Searches',
					middleware: [
						middleware.auth
					]
				},
				children: [
					{
						path: 'edit',
						name: "AdminEditSearch",
						component: () => import ("./../views/EditView.vue"),
						meta: {
							title: 'Editar Searches',
							middleware: [
								middleware.auth
							]
						}
					},
				]
			},
		]
	},
]