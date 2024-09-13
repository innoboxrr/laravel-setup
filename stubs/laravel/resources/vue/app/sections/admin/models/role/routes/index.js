import * as middleware from '@router/middleware'

export default [
	{
		path: 'role',
		name: "AdminRoles",
		component: () => import ("./../views/AdminView.vue"),
		meta: {
			title: 'Roles',
			middleware: [
				middleware.auth, middleware.admin
			]
		},
		children: [
			{
				path: 'create',
				name: "AdminCreateRole",
				component: () => import ("./../views/CreateView.vue"),
				meta: {
					title: 'Create Roles',
					middleware: [
						middleware.auth, middleware.admin
					]
				}
			},
			{
				path: ':id',
				name: "AdminShowRole",
				component: () => import ("./../views/ShowView.vue"),
				meta: {
					title: 'Ver Roles',
					middleware: [
						middleware.auth, middleware.admin
					]
				},
				children: [
					{
						path: 'edit',
						name: "AdminEditRole",
						component: () => import ("./../views/EditView.vue"),
						meta: {
							title: 'Editar Roles',
							middleware: [
								middleware.auth, middleware.admin
							]
						}
					},
				]
			},
		]
	},
]