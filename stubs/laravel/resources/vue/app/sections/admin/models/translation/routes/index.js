import * as middleware from '@router/middleware'

export default [
	{
		path: 'translation',
		name: "AdminTranslations",
		component: () => import ("./../views/AdminView.vue"),
		meta: {
			title: 'Translations',
			middleware: [
				middleware.auth, middleware.admin
			]
		},
		children: [
			{
				path: 'create',
				name: "AdminCreateTranslation",
				component: () => import ("./../views/CreateView.vue"),
				meta: {
					title: 'Create Translations',
					middleware: [
						middleware.auth, middleware.admin
					]
				}
			},
			{
				path: ':id',
				name: "AdminShowTranslation",
				component: () => import ("./../views/ShowView.vue"),
				meta: {
					title: 'Ver Translations',
					middleware: [
						middleware.auth, middleware.admin
					]
				},
				children: [
					{
						path: 'edit',
						name: "AdminEditTranslation",
						component: () => import ("./../views/EditView.vue"),
						meta: {
							title: 'Editar Translations',
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