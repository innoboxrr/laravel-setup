import * as middleware from '@router/middleware'

export default [
	{
		path: 'tracking-event',
		name: "AdminTrackingEvents",
		component: () => import ("./../views/AdminView.vue"),
		meta: {
			title: 'TrackingEvents',
			middleware: [
				middleware.auth
			]
		},
		children: [
			{
				path: 'create',
				name: "AdminCreateTrackingEvent",
				component: () => import ("./../views/CreateView.vue"),
				meta: {
					title: 'Crear TrackingEvents',
					middleware: [
						middleware.auth
					]
				}
			},
			{
				path: ':id',
				name: "AdminShowTrackingEvent",
				component: () => import ("./../views/ShowView.vue"),
				meta: {
					title: 'Ver TrackingEvents',
					middleware: [
						middleware.auth
					]
				},
				children: [
					{
						path: 'edit',
						name: "AdminEditTrackingEvent",
						component: () => import ("./../views/EditView.vue"),
						meta: {
							title: 'Editar TrackingEvents',
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