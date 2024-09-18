export default [
    {
        path: 'search',
        name: "SearchLayout",
        redirect: { name: "SearchDefault" },
        component: () => import("../layout/SearchLayout.vue"),
        meta: {
            title: "Search",
        },
        children: [
            {
                path: 'default',
                name: "SearchDefault",
                component: () => import("./../views/SearchDefaultView.vue"),
                meta: {
                    title: "SearchDefault",
                },
            },
        ]
    }
];
