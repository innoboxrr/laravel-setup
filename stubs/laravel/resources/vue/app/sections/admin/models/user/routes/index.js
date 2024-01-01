import * as middleware from '@router/middleware'

export default [
	{
		path: 'user',
		name: "AdminUsers",
		component: () => import ("./../views/AdminView.vue"),
		meta: {
			title: 'Users',
			middleware: [
				middleware.auth
			]
		},
		children: [
			{
				path: 'create',
				name: "AdminCreateUser",
				component: () => import ("./../views/CreateView.vue"),
				meta: {
					title: 'Crear Users',
					middleware: [
						middleware.auth
					]
				}
			},
			{
				path: ':id',
				name: "AdminShowUser",
				component: () => import ("./../views/ShowView.vue"),
				meta: {
					title: 'Ver Users',
					middleware: [
						middleware.auth
					]
				},
				children: [
					{
						path: 'edit',
						name: "AdminEditUser",
						component: () => import ("./../views/EditView.vue"),
						meta: {
							title: 'Editar Users',
							middleware: [
								middleware.auth
							]
						}
					}
				]
			},
		]
	},
]