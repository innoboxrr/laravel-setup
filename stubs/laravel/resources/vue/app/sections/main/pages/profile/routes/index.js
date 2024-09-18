import * as middleware from '@router/middleware'

export default [
	{
		path: 'profile',
        name: "Profile",
        redirect: { name: "ProfileUser" },
		component: () => import("./../layouts/ProfileLayout.vue"),
		meta: {
			title: "My Profile",
			middleware: [
				middleware.auth
			]
        },
        children: [
            {
                path: 'user',
                name: "ProfileUser",
                redirect: { name: "ProfileUserEdit" },
                component: () => import("./../views/user/UserView.vue"),
                meta: {
                    title: "Edit Profile",
                    middleware: [
                        middleware.auth
                    ]
                },
                children: [
                    {
                        path: 'edit',
                        name: "ProfileUserEdit",
                        component: () => import("./../views/user/EditView.vue"),
                        meta: {
                            title: "Edit Profile",
                            middleware: [
                                middleware.auth
                            ],
                            parent: 'ProfileUser'
                        }
                    },
                    {
                        path: 'advanced-settings',
                        name: "ProfileUserAdvancedSettings",
                        component: () => import("./../views/user/AdvancedSettingsView.vue"),
                        meta: {
                            title: "Advanced Settings",
                            middleware: [
                                middleware.auth
                            ],
                            parent: 'ProfileUser'
                        }
                    },
                    {
                        path: 'notifications',
                        name: "ProfileUserNotifications",
                        component: () => import("./../views/user/NotificationsView.vue"),
                        meta: {
                            title: "Notifications",
                            middleware: [
                                middleware.auth
                            ],
                            parent: 'ProfileUser'
                        }
                    },
                    {
                        path: 'integrations',
                        name: "ProfileUserIntegrations",
                        component: () => import("./../views/user/IntegrationsView.vue"),
                        meta: {
                            title: "Integrations",
                            middleware: [
                                middleware.auth
                            ],
                            parent: 'ProfileUser'
                        }
                    }
                ]
            },
            {
                path: 'cart',
                name: 'ProfileCart',
                redirect: { name: 'ProfileCartIndex' },
                component: () => import("./../views/cart/CartView.vue"),
                meta: {
                    title: "Cart",
                    middleware: [
                        middleware.auth
                    ]
                },
                children: [
                    {
                        path: 'index',
                        name: 'ProfileCartIndex',
                        component: () => import("./../views/cart/IndexView.vue"),
                        meta: {
                            title: "Cart",
                            middleware: [
                                middleware.auth
                            ],
                            parent: 'ProfileCart'
                        }
                    },
                    {
                        path: ':id',
                        name: 'ProfileCartShow',
                        component: () => import("./../views/cart/ShowView.vue"),
                        meta: {
                            title: "Cart",
                            middleware: [
                                middleware.auth
                            ],
                            parent: 'ProfileCart'
                        }
                    }
                ]
            },
            {
                path: 'benefit',
                name: 'ProfileBenefit',
                redirect: { name: 'ProfileBenefitIndex' },
                component: () => import("./../views/benefit/BenefitView.vue"),
                meta: {
                    title: "Benefit",
                    middleware: [
                        middleware.auth
                    ]
                },
                children: [
                    {
                        path: 'index',
                        name: 'ProfileBenefitIndex',
                        component: () => import("./../views/benefit/IndexView.vue"),
                        meta: {
                            title: "Benefit",
                            middleware: [
                                middleware.auth
                            ],
                            parent: 'ProfileBenefit'
                        }
                    },
                    {
                        path: ':id',
                        name: 'ProfileBenefitShow',
                        component: () => import("./../views/benefit/ShowView.vue"),
                        meta: {
                            title: "Benefit",
                            middleware: [
                                middleware.auth
                            ],
                            parent: 'ProfileBenefit'
                        }
                    }
                ]
            },
            {
                path: 'payment',
                name: 'ProfilePayment',
                redirect: { name: 'ProfilePaymentIndex' },
                component: () => import("./../views/payment/PaymentView.vue"),
                meta: {
                    title: "Payment",
                    middleware: [
                        middleware.auth
                    ]
                },
                children: [
                    {
                        path: 'index',
                        name: 'ProfilePaymentIndex',
                        component: () => import("./../views/payment/IndexView.vue"),
                        meta: {
                            title: "Payment",
                            middleware: [
                                middleware.auth
                            ],
                            parent: 'ProfilePayment'
                        }
                    },
                    {
                        path: ':id',
                        name: 'ProfilePaymentShow',
                        component: () => import("./../views/payment/ShowView.vue"),
                        meta: {
                            title: "Payment",
                            middleware: [
                                middleware.auth
                            ],
                            parent: 'ProfilePayment'
                        }
                    }
                ]
            },
            {
                path: 'payout',
                name: 'ProfilePayout',
                redirect: { name: 'ProfilePayoutIndex' },
                component: () => import("./../views/payout/PayoutView.vue"),
                meta: {
                    title: "Payout",
                    middleware: [
                        middleware.auth
                    ]
                },
                children: [
                    {
                        path: 'index',
                        name: 'ProfilePayoutIndex',
                        component: () => import("./../views/payout/IndexView.vue"),
                        meta: {
                            title: "Payout",
                            middleware: [
                                middleware.auth
                            ],
                            parent: 'ProfilePayout'
                        }
                    },
                    {
                        path: ':id',
                        name: 'ProfilePayoutShow',
                        component: () => import("./../views/payout/ShowView.vue"),
                        meta: {
                            title: "Payout",
                            middleware: [
                                middleware.auth
                            ],
                            parent: 'ProfilePayout'
                        }
                    }
                ]
            },
            {
                path: 'wishlist',
                name: 'ProfileWishlist',
                redirect: { name: 'ProfileWishlistIndex' },
                component: () => import("./../views/wishlist/WishlistView.vue"),
                meta: {
                    title: "Wishlist",
                    middleware: [
                        middleware.auth
                    ]
                },
                children: [
                    {
                        path: 'index',
                        name: 'ProfileWishlistIndex',
                        component: () => import("./../views/wishlist/IndexView.vue"),
                        meta: {
                            title: "Wishlist",
                            middleware: [
                                middleware.auth
                            ],
                            parent: 'ProfileWishlist'
                        }
                    },
                    {
                        path: ':id',
                        name: 'ProfileWishlistShow',
                        component: () => import("./../views/wishlist/ShowView.vue"),
                        meta: {
                            title: "Wishlist",
                            middleware: [
                                middleware.auth
                            ],
                            parent: 'ProfileWishlist'
                        }
                    }
                ]
            },
            {
                path: 'product',
                name: 'ProfileProduct',
                redirect: { name: 'ProfileProductCourse' },
                component: () => import("./../views/products/ProductView.vue"),
                meta: {
                    title: "Product",
                    middleware: [
                        middleware.auth
                    ]
                },
                children: [
                    {
                        path: 'course',
                        name: 'ProfileProductCourse',
                        redirect: { name: 'ProfileProductCourseIndex' },
                        component: () => import("./../views/products/course/CourseView.vue"),
                        meta: {
                            title: "Course",
                            middleware: [
                                middleware.auth
                            ],
                            parent: 'ProfileProduct'
                        },
                        children: [
                            {
                                path: 'index',
                                name: 'ProfileProductCourseIndex',
                                component: () => import("./../views/products/course/IndexView.vue"),
                                meta: {
                                    title: "Courses",
                                    middleware: [
                                        middleware.auth
                                    ],
                                    parent: 'ProfileProductCourse'
                                }
                            },
                            {
                                path: ':id',
                                name: 'ProfileProductCourseShow',
                                component: () => import("./../views/products/course/ShowView.vue"),
                                meta: {
                                    title: "Course",
                                    middleware: [
                                        middleware.auth
                                    ],
                                    parent: 'ProfileProductCourse'
                                }
                            }
                        ]
                    },
                    {
                        path: 'package',
                        name: 'ProfileProductPackage',
                        redirect: { name: 'ProfileProductPackageIndex' },
                        component: () => import("./../views/products/package/PackageView.vue"),
                        meta: {
                            title: "Package",
                            middleware: [
                                middleware.auth
                            ],
                            parent: 'ProfileProduct'
                        },
                        children: [
                            {
                                path: 'index',
                                name: 'ProfileProductPackageIndex',
                                component: () => import("./../views/products/package/IndexView.vue"),
                                meta: {
                                    title: "Packages",
                                    middleware: [
                                        middleware.auth
                                    ],
                                    parent: 'ProfileProductPackage'
                                }
                            },
                            {
                                path: ':id',
                                name: 'ProfileProductPackageShow',
                                component: () => import("./../views/products/package/ShowView.vue"),
                                meta: {
                                    title: "Package",
                                    middleware: [
                                        middleware.auth
                                    ],
                                    parent: 'ProfileProductPackage'
                                }
                            }
                        ]
                    },
                    {
                        path: 'quiz',
                        name: 'ProfileProductQuiz',
                        redirect: { name: 'ProfileProductQuizIndex' },
                        component: () => import("./../views/products/quiz/QuizView.vue"),
                        meta: {
                            title: "Quiz",
                            middleware: [
                                middleware.auth
                            ],
                            parent: 'ProfileProduct'
                        },
                        children: [
                            {
                                path: 'index',
                                name: 'ProfileProductQuizIndex',
                                component: () => import("./../views/products/quiz/IndexView.vue"),
                                meta: {
                                    title: "Quizzes",
                                    middleware: [
                                        middleware.auth
                                    ],
                                    parent: 'ProfileProductQuiz'
                                }
                            },
                            {
                                path: ':id?',
                                name: 'ProfileProductQuizShow',
                                component: () => import("./../views/products/quiz/ShowView.vue"),
                                meta: {
                                    title: "Quiz",
                                    middleware: [
                                        middleware.auth
                                    ],
                                    parent: 'ProfileProductQuiz'
                                }
                            }
                        ]
                    },
                    {
                        path: 'testkin',
                        name: 'ProfileProductTestkin',
                        redirect: { name: 'ProfileProductTestkinIndex' },
                        component: () => import("./../views/products/testkin/TestkinView.vue"),
                        meta: {
                            title: "Testkin",
                            middleware: [
                                middleware.auth
                            ],
                            parent: 'ProfileProduct'
                        },
                        children: [
                            {
                                path: 'index',
                                name: 'ProfileProductTestkinIndex',
                                component: () => import("./../views/products/testkin/IndexView.vue"),
                                meta: {
                                    title: "Testkins",
                                    middleware: [
                                        middleware.auth
                                    ],
                                    parent: 'ProfileProductTestkin'
                                }
                            },
                            {
                                path: ':id',
                                name: 'ProfileProductTestkinShow',
                                component: () => import("./../views/products/testkin/ShowView.vue"),
                                meta: {
                                    title: "Testkin",
                                    middleware: [
                                        middleware.auth
                                    ],
                                    parent: 'ProfileProductTestkin'
                                }
                            }
                        ]
                    },
                    {
                        path: 'voucher',
                        name: 'ProfileProductVoucher',
                        redirect: { name: 'ProfileProductVoucherIndex' },
                        component: () => import("./../views/products/voucher/VoucherView.vue"),
                        meta: {
                            title: "Voucher",
                            middleware: [
                                middleware.auth
                            ],
                            parent: 'ProfileProduct'
                        },
                        children: [
                            {
                                path: 'index',
                                name: 'ProfileProductVoucherIndex',
                                component: () => import("./../views/products/voucher/IndexView.vue"),
                                meta: {
                                    title: "Vouchers",
                                    middleware: [
                                        middleware.auth
                                    ],
                                    parent: 'ProfileProductVoucher'
                                }
                            },
                            {
                                path: ':id',
                                name: 'ProfileProductVoucherShow',
                                component: () => import("./../views/products/voucher/ShowView.vue"),
                                meta: {
                                    title: "Voucher",
                                    middleware: [
                                        middleware.auth
                                    ],
                                    parent: 'ProfileProductVoucher'
                                }
                            }
                        ]
                    },
                ]
            }
        ]
    },
];