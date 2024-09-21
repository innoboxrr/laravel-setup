<template>
    <aside class="hidden md:block fixed right-0 top-0 bottom-0 z-30 w-16 h-full bg-white border-l border-gray-200 dark:bg-gray-800 dark:border-gray-700 pt-14 overflow-y-auto hide-scrollbar">
        <div class="divide-y divide-gray-100 dark:divide-gray-700">
            <ul class="space-y-2 py-5 px-3">
                <li v-if="false">
                    <router-link 
                        :to="{
                            name: 'AdminReports'
                        }"
                        :uk-tooltip="`title: ${__('Reports')}; pos: left`"
                        class="flex items-center p-2 text-gray-500 rounded-lg transition duration-75 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11 4a1 1 0 10-2 0v4a1 1 0 102 0V7zm-3 1a1 1 0 10-2 0v3a1 1 0 102 0V8zM8 9a1 1 0 00-2 0v2a1 1 0 102 0V9z"></path>
                        </svg>
                        <span class="sr-only"></span>
                    </router-link>
                </li>
                <li>
                    <router-link 
                        :to="{
                            name: 'ProfileWishlistIndex'
                        }"
                        :uk-tooltip="`title: ${__('Wishlist')}; pos: left`"
                        class="flex items-center p-2 text-gray-500 rounded-lg transition duration-75 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-heart h-6 w-6 pt-1 pl-1"></i>
                        <span class="sr-only">{{ __('Wishlist') }}</span>
                    </router-link>
                </li>
                <li>          
                    <router-link 
                        :to="{
                            name: 'AdminConversations'
                        }"
                        :uk-tooltip="`title: ${__('Conversations')}; pos: left`"
                        class="flex items-center p-2 text-gray-500 rounded-lg transition duration-75 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fa-solid fa-inbox fa-md py-1 mx-auto"></i>
                    </router-link>
                </li>
                <li>
                    <router-link
                        :to="{
                            name: 'CalendarEvents'
                        }"
                        :uk-tooltip="`title: ${__('Calendar')}; pos: left`"
                        class="flex items-center p-2 text-gray-500 rounded-lg transition duration-75 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fa-solid fa-calendar fa-md py-1 mx-auto"></i>
                    </router-link>
                </li>
                <!-- Pending views -->
                <!-- Chat room -->
                <!-- Payments -->
            </ul>

            <ul 
                v-if="!$store.getters['authPages/isAdmin'] && 
                    !$store.getters['authPages/isTeacher'] && 
                    !$store.getters['authPages/isEditTeacher'] &&
                    !$store.getters['authPages/isHeadTeacher']"
                class="space-y-2 pt-2">
                <li>
                    <router-link
                        :to="{name: 'ProfileProductCourse'}"
                        :uk-tooltip="`title: ${__('My courses')}; pos: left`"
                        class="flex items-center p-2 text-gray-500 rounded-lg transition duration-75 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fa-solid fa-graduation-cap fa-md py-1 mx-auto"></i>
                    </router-link>
                </li> 
                <li>
                    <router-link 
                        :to="{name: 'ProfileProductTestkin'}"
                        uk-tooltip="title: My exams; pos: left"
                        class="flex items-center p-2 text-gray-500 rounded-lg transition duration-75 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700 hover:no-underline">
                        <i class="fa-solid fa-clipboard-question fa-md py-1 mx-auto"></i>
                        <span class="sr-only"></span>
                    </router-link>
                </li>
                <li>
                    <router-link 
                        :to="{name: 'ProfileProductVoucher'}"
                        uk-tooltip="title: My vouchers; pos: left"
                        class="flex items-center p-2 text-gray-500 rounded-lg transition duration-75 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700 hover:no-underline">
                        <i class="fa-solid fa-ticket fa-md py-1 mx-auto"></i>
                        <span class="sr-only"></span>
                    </router-link>
                </li> 
                <li>
                    <router-link 
                        :to="{name: 'ProfileProductQuiz'}"
                        uk-tooltip="title: Mys Quizzes; pos: left"
                        class="flex items-center p-2 text-gray-500 rounded-lg transition duration-75 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700 hover:no-underline">
                        <i class="fa-solid fa-list-check fa-md py-1 mx-auto"></i>
                        <span class="sr-only"></span>
                    </router-link>
                </li>       
            </ul>

            <ul 
                v-if="hasRoles(['admin', 'teacher', 'edit-teacher', 'head-teacher'])"
                class="space-y-2 py-5 px-3">
                <li v-if="hasRoles(['admin', 'teacher', 'edit-teacher', 'head-teacher'])">
                    <router-link
                        :to="{name: 'CourseManager'}"
                        :uk-tooltip="`title: ${__('Course management')}; pos: left`"
                        class="flex items-center p-2 text-gray-500 rounded-lg transition duration-75 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fa-solid fa-graduation-cap fa-md py-1 mx-auto"></i>
                    </router-link>
                </li> 
                <li v-if="hasRoles(['admin'])">
                    <router-link 
                        :to="{name: 'TestkinManager'}"
                        uk-tooltip="title: Testkin management; pos: left"
                        class="flex items-center p-2 text-gray-500 rounded-lg transition duration-75 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700 hover:no-underline">
                        <i class="fa-solid fa-clipboard-question fa-md py-1 mx-auto"></i>
                        <span class="sr-only"></span>
                    </router-link>
                </li>
                <li v-if="hasRoles(['admin'])">
                    <router-link 
                        :to="{name: 'VoucherManager'}"
                        uk-tooltip="title: Voucher management; pos: left"
                        class="flex items-center p-2 text-gray-500 rounded-lg transition duration-75 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700 hover:no-underline">
                        <i class="fa-solid fa-ticket fa-md py-1 mx-auto"></i>
                        <span class="sr-only"></span>
                    </router-link>
                </li> 
                <li v-if="hasRoles(['admin'])">
                    <router-link 
                        :to="{name: 'QuizManager'}"
                        uk-tooltip="title: Quizzes management; pos: left"
                        class="flex items-center p-2 text-gray-500 rounded-lg transition duration-75 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700 hover:no-underline">
                        <i class="fa-solid fa-list-check fa-md py-1 mx-auto"></i>
                        <span class="sr-only"></span>
                    </router-link>
                </li>  
                <li v-if="hasRoles(['admin'])">
                    <router-link 
                        :to="{name: 'PackageManager'}"
                        uk-tooltip="title: Package management; pos: left"
                        class="flex items-center p-2 text-gray-500 rounded-lg transition duration-75 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700 hover:no-underline">
                        <i class="fa-solid fa-cubes fa-md py-1 mx-auto"></i>
                        <span class="sr-only"></span>
                    </router-link>
                </li>  
                <li v-if="hasRoles(['admin', 'head-teacher'])">
                    <router-link 
                        :to="{
                            name: 'EcommerceManager',
                            query: hasRoles(['head-teacher']) ? { step: 'courses' } : {}
                        }"
                        uk-tooltip="title: Ecommerce management; pos: left"
                        class="flex items-center p-2 text-gray-500 rounded-lg transition duration-75 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700 hover:no-underline">
                        <i class="fa-solid fa-dollar-sign fa-md py-1 mx-auto"></i>
                        <span class="sr-only"></span>
                    </router-link>
                </li>
            </ul>
        </div>
    </aside>
</template>