export default [

	{
		path: '404',
		name: "ErrorNotFound",
		component: () => import(/* webpackChunkName: "ErrorNotFound"*/ "./../views/CustomView.vue"),
		meta: {
			title: "Error 404",
		},
	}

];