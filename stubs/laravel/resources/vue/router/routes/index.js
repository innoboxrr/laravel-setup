export const siteRoutes = [

	{
		path: '/',
		name: "Site",
		component: () => import(/* webpackChunkName: "SiteLayout"*/ "@layouts/site/SiteLayout.vue"),
		meta: {
			title: "Sitio",
		},
		children: []
	}
	
];

export const adminRoutes = [

	{
		path: '/admin',
		name: "Admin",
		component: () => import(/* webpackChunkName: "AdminLayout"*/ "@layouts/admin/AdminLayout.vue"),
		meta: {
			title: "Administración",
		},
		children: []
	}
	
];

export const routes = [].concat(

	adminRoutes,

	siteRoutes
	// Register routes

);