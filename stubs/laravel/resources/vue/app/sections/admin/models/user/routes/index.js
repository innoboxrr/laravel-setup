import * as middleware from '@router/middleware'

export default [
	{
		path: 'user',
		name: "AdminUsers",
		component: () => import (/* webpackChunkName: "AdminUsers"*/ "./../AdminView.vue"),
		meta: {
			title: 'Panel de administración',
			middleware: [
				middleware.auth
			]
		},
		children: [
			{
				path: 'create',
				name: "AdminCreateUser",
				component: () => import (/* webpackChunkName: "CreateUser"*/ "./../CreateView.vue"),
				meta: {
					title: 'Crear',
					middleware: [
						middleware.auth
					]
				}
			},
			{
				path: ':id/show',
				name: "AdminShowUser",
				component: () => import (/* webpackChunkName: "ShowUser"*/ "./../ShowView.vue"),
				meta: {
					title: undefined,
					middleware: [
						middleware.auth
					]
				}
			},
			{
				path: ':id/edit',
				name: "AdminEditUser",
				component: () => import (/* webpackChunkName: "EditUser"*/ "./../EditView.vue"),
				meta: {
					title: 'Editar',
					middleware: [
						middleware.auth
					]
				}
			},
		]
	},
]