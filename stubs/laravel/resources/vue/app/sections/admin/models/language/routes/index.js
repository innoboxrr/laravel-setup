import * as middleware from '@router/middleware'

export default [
	{
		path: 'language',
		name: "AdminLanguages",
		component: () => import ("./../views/AdminView.vue"),
		meta: {
			title: 'Languages',
			middleware: [
				middleware.auth, middleware.admin
			]
		},
		children: [
			{
				path: 'create',
				name: "AdminCreateLanguage",
				component: () => import ("./../views/CreateView.vue"),
				meta: {
					title: 'Create Languages',
					middleware: [
						middleware.auth, middleware.admin
					]
				}
			},
			{
				path: ':id',
				name: "AdminShowLanguage",
				component: () => import ("./../views/ShowView.vue"),
				meta: {
					title: 'Ver Languages',
					middleware: [
						middleware.auth, middleware.admin
					]
				},
				children: [
					{
						path: 'edit',
						name: "AdminEditLanguage",
						component: () => import ("./../views/EditView.vue"),
						meta: {
							title: 'Editar Languages',
							middleware: [
								middleware.auth, middleware.admin
							]
						}
					},
					{
						path: 'edit-json',
						name: "AdminEditJsonLanguage",
						component: () => import ("./../views/EditJsonView.vue"),
						meta: {
							title: 'Editar Language Json',
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