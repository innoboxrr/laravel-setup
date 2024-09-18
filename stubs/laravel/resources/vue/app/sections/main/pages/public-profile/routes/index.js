export default [

    {
        path: 'user/:user_id',
        name: "PublicProfileLayout",
        redirect: { name: "ProfileUserShow" },
        component: () => import("./../layout/PublicProfileLayout.vue"),
        meta: {
            title: "User profile",
        },
        children: [
            {
                path: 'profile',
                name: "ProfileUserShow",
                component: () => import("./../views/UserView.vue"),
                meta: {
                    title: "User",
                },
            },
            {
                path: 'certificate/:certificate_id',
                name: "ProfileUserCertificate",
                component: () => import("./../views/CertificateView.vue"),
                meta: {
                    title: "Certificate",
                },
            }
        ]       
    }
];
