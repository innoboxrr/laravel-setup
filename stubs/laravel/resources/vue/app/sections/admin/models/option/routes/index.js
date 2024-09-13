import * as middleware from '@router/middleware'

export default [
	{
		path: 'option',
		name: "AdminOptions",
		component: () => import ("./../views/AdminView.vue"),
		meta: {
			title: 'Options',
			middleware: [
				middleware.auth, middleware.admin
			]
		},
		children: [
			{
				path: 'create',
				name: "AdminCreateOption",
				component: () => import ("./../views/CreateView.vue"),
				meta: {
					title: 'Create Options',
					middleware: [
						middleware.auth, middleware.admin
					]
				}
			},
			{
				path: ':id',
				name: "AdminShowOption",
				component: () => import ("./../views/ShowView.vue"),
				meta: {
					title: 'Ver Options',
					middleware: [
						middleware.auth, middleware.admin
					]
				},
				children: [
					{
						path: 'edit',
						name: "AdminEditOption",
						component: () => import ("./../views/EditView.vue"),
						meta: {
							title: 'Editar Options',
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