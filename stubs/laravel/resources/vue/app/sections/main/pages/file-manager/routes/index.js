export default [

    {
        path: 'file-manager',
        name: "FileManager",
        component: () => import("../views/FileManager.vue"),
        meta: {
            title: "File manager",
        },     
    }
];
