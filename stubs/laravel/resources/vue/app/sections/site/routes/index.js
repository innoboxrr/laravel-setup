export default [

	{
		path: '/site',
		name: "Site",
        redirect: { name: 'Home'},
		component: () => import("../layout/SiteLayout.vue"),
		children: [
            {
                path: '/',
                name: 'Home',
                component: () => import("../pages/HomePage.vue"),
            },
            {
                path: '/privacy',
                name: 'Privacy',
                component: () => import("../pages/PrivacyPage.vue"),
            },
            {
                path: '/terms',
                name: 'Terms',
                component: () => import("../pages/TermsPage.vue"),
            },
            {
                path: '/contact',
                name: 'Contact',
                component: () => import("../pages/ContactPage.vue"),
            },
            {
                path: '/join',
                name: 'Join',
                component: () => import("../pages/JoinPage.vue"),
            }
		]
	}

];
