<template>
    <div>
        <div
            v-flowbite
            id="admin-crud-sidenav"
            class="flex flex-col justify-between overflow-y-auto py-5 px-3 w-64 bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700 uk-animation-slide-left h-full">
            <ul class="space-y-2 pt-12">
                <li>
                    <a 
                        href="#" 
                        class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <span class="ml-3">
                            {{ __('Dashboard') }}
                        </span>
                    </a>
                </li>
                <li 
                    v-for="crudGroup in crudGroups"
                    :key="crudGroup.id">
                    <button 
                        v-flowbite
                        type="button" 
                        class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" 
                        :aria-controls="`dropdown-pages-${crudGroup.id}`" 
                        :data-collapse-toggle="`dropdown-pages-${crudGroup.id}`">
                        <span class="flex-1 ml-3 text-left whitespace-nowrap">
                            {{ crudGroup.name }}
                        </span>
                        <i class="fa-solid fa-angle-down"></i>
                    </button>
                    <ul :id="`dropdown-pages-${crudGroup.id}`" class="hidden py-2 space-y-2">
                        <li 
                            v-for="model in crudGroup.models"
                            :key="crudGroup.id + '-' + model.route">
                            <router-link
                                :to="{
                                    name: model.route
                                }"
                                class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                data-drawer-target="topbar-drawer"
                                data-drawer-toggle="topbar-drawer"
                                @click="$emit('hideSidenav')">
                                {{ model.name }}
                            </router-link>
                        </li>
                    </ul>
                </li>
            </ul>
            <div class="flex justify-end w-full bg-white dark:bg-gray-800">
                <button
                    type="button"
                    class="inline-flex p-2 text-gray-500 rounded-full cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white"
                    @click="$emit('hideSidenav')">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
            </div>
        </div>
        <div class="overlay" @click="$emit('hideSidenav')"></div>
    </div>
</template>

<script>

    export default {

        name: 'AdminCrudSidenav',

        emits: ['hideSidenav'], 

        data() {
            return {
                crudGroups: [
                    {
                        id: 'administration',
                        name: 'Administration',
                        route: null,
                        models: [
                            {
                                name: 'Site options',
                                route: 'AdminOptions'
                            },
                            {
                                name: 'Users',
                                route: 'AdminUsers'
                            },
                            {
                                name: 'Roles',
                                route: 'AdminRoles'
                            },
                            {
                                name: 'Permissions',
                                route: 'AdminPermissions'
                            },
                            {
                                name: 'Countries',
                                route: 'AdminCountries'
                            },
                            {
                                name: 'Categories',
                                route: 'AdminCategories'
                            },
                            {
                                name: 'Languages',
                                route: 'AdminLanguages'
                            },
                            {
                                name: 'Translations',
                                route: 'AdminTranslations'
                            },
                            {
                                name: 'Categories',
                                route: 'AdminCategories'
                            },
                            {
                                name: 'Contacts',
                                route: 'AdminContacts'
                            }
                        ]
                    },
                    {
                        id: 'lms',
                        name: 'Academy',
                        route: null,
                        models: [
                            {
                                name: 'Courses',
                                route: 'AdminCourses'
                            },
                            {
                                name: 'Enrollments',
                                route: 'AdminEnrollments'
                            },
                            {
                                name: 'Certificates',
                                route: 'AdminCertificates'
                            },
                            {
                                name: 'Trackers',
                                route: 'AdminTrackers'
                            },
                        ]
                    },
                    {
                        id: 'communication',
                        name: 'Communication',
                        route: null,
                        models: [
                            {
                                name: 'Conversation',
                                route: 'AdminConversations'
                            },
                            {
                                name: 'Messages',
                                route: 'AdminMessages'
                            },
                            {
                                name: 'Reviews',
                                route: 'AdminReviews'
                            },
                            {
                                name: 'Comments',
                                route: 'AdminComments'
                            },
                            {
                                name: 'CommentViewers',
                                route: 'AdminCommentViewers'
                            },
                            // Añadir la ruta de notificaciones
                        ]
                    },
                    {
                        id: 'courses',
                        name: 'Courses',
                        route: null,
                        models: [
                            {
                                name: 'Sections',
                                route: 'AdminSections'
                            },
                            {
                                name: 'Lessons',
                                route: 'AdminLessons'
                            },
                            {
                                name: 'Lectures',
                                route: 'AdminLectures'
                            },
                            {
                                name: 'Theories',
                                route: 'AdminTheories'
                            },
                            {
                                name: 'Videos',
                                route: 'AdminVideos'
                            },
                            {
                                name: 'Subtitles',
                                route: 'AdminSubtitles'
                            },
                        ]
                    },
                    {
                        id: 'bootcamp',
                        name: 'Bootcamp',
                        route: null,
                        models: [
                            {
                                name: 'Bootcamps',
                                route: 'AdminBootcamps'
                            },
                            {
                                name: 'Live classes',
                                route: 'AdminLiveClasses'
                            },
                            {
                                name: 'Attendances',
                                route: 'AdminAttendances'
                            }
                        ]
                    },
                    {
                        id: 'vouchers',
                        name: 'Voucher',
                        route: null,
                        models: [
                            {
                                name: 'Vouchers',
                                route: 'AdminVouchers'
                            },
                            {
                                name: 'Voucher sents',
                                route: 'AdminVoucherSents'
                            }
                        ]
                    },
                    {
                        id: 'testkins',
                        name: 'Testkin',
                        route: null,
                        models: [
                            {
                                name: 'Testkins',
                                route: 'AdminTestkins'
                            },
                            {
                                name: 'Quizzes',
                                route: 'AdminQuizzes'
                            },
                            {
                                name: 'Quizzables',
                                route: 'AdminQuizzables'
                            },
                            {
                                name: 'Questions',
                                route: 'AdminQuestions'
                            },
                            {
                                name: 'Attempts',
                                route: 'AdminAttempts'
                            },
                            {
                                name: 'Answers',
                                route: 'AdminAnswers'
                            },
                        ]
                    },
                    {
                        id: 'ecommerce',
                        name: 'eCommerce',
                        route: null,
                        models: [
                            {
                                name: 'Products',
                                route: 'AdminProducts'
                            },
                            {
                                name: 'Packages',
                                route: 'AdminPackages'
                            },
                            {
                                name: 'Prices',
                                route: 'AdminPrices'
                            },
                            {
                                name: 'Benefits',
                                route: 'AdminBenefits'
                            },
                            {
                                name: 'Subscriptions',
                                route: 'AdminSubscriptions'
                            },
                            {
                                name: 'Wishlists',
                                route: 'AdminWishlists'
                            },
                            {
                                name: 'Wishlist items',
                                route: 'AdminWishlistItems'
                            },
                            {
                                name: 'Carts',
                                route: 'AdminCarts'
                            },
                            {
                                name: 'Cart items',
                                route: 'AdminCartItems'
                            },
                            {
                                name: 'Payments',
                                route: 'AdminPayments'
                            },
                            {
                                name: 'Payment methods',
                                route: 'AdminPaymentMethods'
                            },
                            {
                                name: 'Coupons',
                                route: 'AdminCoupons'
                            },
                            {
                                name: 'Revenues',
                                route: 'AdminRevenues'
                            },
                            {
                                name: 'Payouts',
                                route: 'AdminPayouts'
                            },
                        ]
                    },
                ]
            }
        }
    }

</script>

<style scoped>
    .overlay {
        position: fixed; /* Cambiado a fixed para cubrir toda la pantalla */
        top: 0;
        left: 0;
        z-index: 40; /* Ajusta este valor según sea necesario, pero debe ser menor que el z-index del sidenav */
        width: 100vw; /* Usa vw/vh para cubrir todo el viewport */
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.5);
    }

    #admin-crud-sidenav {
        /* Asegúrate de que tu sidenav tenga un z-index más alto que el overlay */
        z-index: 50; /* Este valor debe ser mayor que el del overlay */
        position: fixed; /* O absolute, según tu diseño */
        /* Resto de tus estilos */
    }
</style>