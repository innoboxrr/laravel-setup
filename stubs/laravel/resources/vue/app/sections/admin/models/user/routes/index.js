import * as middleware from '@router/middleware'

export default [
	{
		path: 'user',
		name: "AdminUsers",
		component: () => import ("./../views/AdminView.vue"),
		meta: {
			title: 'Users',
			middleware: [
				middleware.auth, middleware.admin
			]
		},
		children: [
			{
				path: 'create',
				name: "AdminCreateUser",
				component: () => import ("./../views/CreateView.vue"),
				meta: {
					title: 'Create Users',
					middleware: [
						middleware.auth, middleware.admin
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
						middleware.auth, middleware.admin
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
								middleware.auth, middleware.admin
							]
						}
					},
					{
						path: 'assign-role',
						name: "AdminAssignRoleUser",
						component: () => import ("./../views/AssignRoleView.vue"),
						meta: {
							title: 'Assign Role to User',
							middleware: [
								middleware.auth, middleware.admin
							]
						}
					},
					{
						path: 'assign-permission',
						name: "AdminAssignPermissionUser",
						component: () => import ("./../views/AssignPermissionView.vue"),
						meta: {
							title: 'Assign Permission to User',
							middleware: [
								middleware.auth, middleware.admin
							]
						}
					},
					{
						path: 'assign-benefit',
						name: "AdminAssignBenefitUser",
						component: () => import ("./../views/AssignBenefitView.vue"),
						meta: {
							title: 'Assign Benefit to User',
							middleware: [
								middleware.auth, middleware.admin
							]
						}
					}
				]
			},
		]
	},
]