import * as middleware from '@router/middleware'

export default [
	{
		path: 'permission',
		name: "AdminPermissions",
		component: () => import ("./../views/AdminView.vue"),
		meta: {
			title: 'Permissions',
			middleware: [
				middleware.auth, middleware.admin
			]
		},
		children: [
			{
				path: 'create',
				name: "AdminCreatePermission",
				component: () => import ("./../views/CreateView.vue"),
				meta: {
					title: 'Crear Permissions',
					middleware: [
						middleware.auth, middleware.admin
					]
				}
			},
			{
				path: 'permissions-roles',
				name: "AdminPermissionsRoles",
				component: () => import ("./../views/PermissionsRolesView.vue"),
				meta: {
					title: 'Permissions Roles',
					middleware: [
						middleware.auth, middleware.admin
					]
				}
			},
			{
				path: ':id',
				name: "AdminShowPermission",
				component: () => import ("./../views/ShowView.vue"),
				meta: {
					title: 'Ver Permissions',
					middleware: [
						middleware.auth, middleware.admin
					]
				},
				children: [
					{
						path: 'edit',
						name: "AdminEditPermission",
						component: () => import ("./../views/EditView.vue"),
						meta: {
							title: 'Editar Permissions',
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