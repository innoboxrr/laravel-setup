export default [

	{
		path: 'dashboard',
		name: "AdminDashboard",
		component: () => import(/* webpackChunkName: "AdminDashboard"*/ "./../views/CustomView.vue"),
		meta: {
			title: "Panel de administración",
		},
	}
	
];