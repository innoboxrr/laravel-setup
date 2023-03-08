import * as middleware from '@router/middleware'

export default [
	{
		path: 'user',
		name: "AdminUsers",
		component: () => import (/* webpackChunkName: "AdminUsers"*/ "@models/views/user/AdminUsers"),
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
				component: () => import (/* webpackChunkName: "CreateUser"*/ "@models/views/user/CreateUser"),
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
				component: () => import (/* webpackChunkName: "ShowUser"*/ "@models/views/user/ShowUser"),
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
				component: () => import (/* webpackChunkName: "EditUser"*/ "@models/views/user/EditUser"),
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