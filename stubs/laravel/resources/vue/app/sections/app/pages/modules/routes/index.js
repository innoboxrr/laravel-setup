export default [
    {
        path: 'voucher-manager',
        name: "VoucherManager",
        component: () => import("./../views/VoucherManagerView.vue"),
        meta: {
            title: "Vouchers",
        },
    },
    {
        path: 'testkin-manager',
        name: "TestkinManager",
        component: () => import("./../views/TestkinManagerView.vue"),
        meta: {
            title: "Testkins",
        },
    },
    {
        path: 'quiz-manager',
        name: "QuizManager",
        component: () => import("./../views/QuizManagerView.vue"),
        meta: {
            title: "Quizzes",
        },
    },
    {
        path: 'package-manager',
        name: "PackageManager",
        component: () => import("./../views/PackageManagerView.vue"),
        meta: {
            title: "Packages",
        },
    },
    {
        path: 'quiz-attempt/:quizzable_id',
        name: "QuizAttempt",
        component: () => import("./../views/QuizAttemptView.vue"),
        meta: {
            title: "Quiz Attempt",
        },
    },
    {
        path: 'quiz-attempt-review',
        name: "QuizAttemptReview",
        component: () => import("./../views/QuizAttemptReviewView.vue"),
        meta: {
            title: "Quiz Attempt Review",
        },
    },
    {
        path: 'course-manager',
        name: "CourseManager",
        component: () => import("./../views/CourseManagerView.vue"),
        meta: {
            title: "Lms Builder",
        }
    },
    {
        path: 'course-classroom',
        name: "CourseClassroom",
        component: () => import("./../views/CourseClassroomView.vue"),
        meta: {
            title: "Lms Classroom",
        }
    },
    {
        path: 'ecommerce-manager',
        name: "EcommerceManager",
        component: () => import("./../views/EcommerceManagerView.vue"),
        meta: {
            title: "eCommerce manager",
        },
    }
];
