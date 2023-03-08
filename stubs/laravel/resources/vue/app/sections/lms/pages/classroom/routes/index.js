export default [

	{
		path: 'classroom',
		name: "LmsClassroom",
		component: () => import(/* webpackChunkName: "LmsClassroom"*/ "./../views/CustomView.vue"),
		meta: {
			title: "Salón de clase",
		},
	}

];