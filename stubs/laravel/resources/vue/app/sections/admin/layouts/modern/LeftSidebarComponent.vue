<template>
    <div v-flowbite>
        <aside
            id="topbar-drawer"
            class="flex z-40 fixed top-0 left-0 h-full transition-transform -translate-x-full md:translate-x-0"
            aria-label="Sidebar">
            <div class="mt-16 md:mt-0 overflow-y-auto z-50 py-5 px-3 w-16 h-full bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700 hide-scrollbar divide-y divide-gray-100 dark:divide-gray-700">
                <a href="/">
                    <img 
                        :src="icon96x96" 
                        class="mb-6 h-7 mx-auto" 
                        :alt="appName" />
                </a>
                <ul class="space-y-2 pb-2">
                    <li>
                        <router-link
                            :to="{
                                name: 'AdminStart'
                            }"
                            class="flex items-center p-2 text-gray-400 rounded-lg transition duration-75 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700"
                            data-drawer-target="topbar-drawer"
                            data-drawer-toggle="topbar-drawer">
                            <i class="fa-solid fa-house fa-md py-1 mx-auto"></i>
                        </router-link>
                    </li>
                    <li>
                        <router-link
                            :to="{
                                name: 'AppBrowser'
                            }"
                            class="flex items-center p-2 text-gray-400 rounded-lg transition duration-75 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700"
                            data-drawer-target="topbar-drawer"
                            data-drawer-toggle="topbar-drawer">
                            <i class="fa-solid fa-magnifying-glass fa-md py-1 mx-auto"></i>
                        </router-link>  
                    </li>
                    <li v-if="fileManager">
                        <router-link
                            :to="{
                                name: 'FileManager'
                            }"
                            class="flex items-center p-2 text-gray-400 rounded-lg transition duration-75 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700"
                            data-drawer-target="topbar-drawer"
                            data-drawer-toggle="topbar-drawer">
                            <i class="fa-regular fa-folder-open fa-md py-1 mx-auto"></i>
                        </router-link>  
                    </li>
                    <!-- Docs link -->
                    <li>
                        <a 
                            v-if="docsLink"
                            :href="docksLink" 
                            target="_blank" 
                            class="flex items-center p-2 text-gray-400 rounded-lg transition duration-75 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                            <i class="fa-solid fa-book-open fa-md py-1 mx-auto"></i>
                        </a>
                    </li>
                    <li v-if="$store.getters['authPages/isAdmin']">
                        <a
                            class="flex items-center p-2 text-gray-400 rounded-lg transition duration-75 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700"
                            @click="toggleSidenav('adminCrud')">
                            <i class="fa-solid fa-screwdriver-wrench fa-md py-1 mx-auto"></i>
                        </a>
                    </li>
                    <li v-if="$store.getters['authPages/isAdmin']">
                        <a
                            class="flex items-center p-2 text-gray-400 rounded-lg transition duration-75 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700"
                            @click="toggleSidenav('baseSidenav')">
                            <i class="fa-solid fa-cog fa-md py-1 mx-auto"></i>
                        </a>
                    </li>
                    <li v-if="$store.getters['authPages/isAdmin']">
                        <a href="/log-viewer" target="_blank" class="flex items-center p-2 text-gray-400 rounded-lg transition duration-75 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                            <i class="fa-solid fa-bug fa-md py-1 mx-auto"></i>
                        </a>
                    </li>
                    <li v-if="$store.getters['authPages/isAdmin']">
                        <a href="/env-editor" target="_blank" class="flex items-center p-2 text-gray-400 rounded-lg transition duration-75 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                            <i class="fa-solid fa-cog fa-md py-1 mx-auto"></i>
                        </a>
                    </li>
                </ul>
                <ul 
                    v-if="$store.getters['authPages/isAdmin'] || 
                        $store.getters['authPages/isTeacher'] || 
                        $store.getters['authPages/isEditTeacher'] ||
                        $store.getters['authPages/isHeadTeacher']"
                    class="space-y-2 pt-2">
                    <li>
                        <router-link
                            :to="{name: 'ProfileProductCourse'}"
                            :uk-tooltip="`title: ${__('My courses')}; pos: left`"
                            class="flex items-center p-2 text-gray-500 rounded-lg transition duration-75 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700"
                            data-drawer-target="topbar-drawer"
                            data-drawer-toggle="topbar-drawer">
                            <i class="fa-solid fa-graduation-cap fa-md py-1 mx-auto"></i>
                        </router-link>
                    </li> 
                    <li>
                        <router-link 
                            :to="{name: 'ProfileProductTestkin'}"
                            uk-tooltip="title: My exams; pos: left"
                            class="flex items-center p-2 text-gray-500 rounded-lg transition duration-75 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700 hover:no-underline"
                            data-drawer-target="topbar-drawer"
                            data-drawer-toggle="topbar-drawer">
                            <i class="fa-solid fa-clipboard-question fa-md py-1 mx-auto"></i>
                            <span class="sr-only"></span>
                        </router-link>
                    </li>
                    <li>
                        <router-link 
                            :to="{name: 'ProfileProductVoucher'}"
                            uk-tooltip="title: My vouchers; pos: left"
                            class="flex items-center p-2 text-gray-500 rounded-lg transition duration-75 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700 hover:no-underline"
                            data-drawer-target="topbar-drawer"
                            data-drawer-toggle="topbar-drawer">
                            <i class="fa-solid fa-ticket fa-md py-1 mx-auto"></i>
                            <span class="sr-only"></span>
                        </router-link>
                    </li> 
                    <li>
                        <router-link 
                            :to="{name: 'ProfileProductQuiz'}"
                            uk-tooltip="title: Mys Quizzes; pos: left"
                            class="flex items-center p-2 text-gray-500 rounded-lg transition duration-75 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700 hover:no-underline"
                            data-drawer-target="topbar-drawer"
                            data-drawer-toggle="topbar-drawer">
                            <i class="fa-solid fa-list-check fa-md py-1 mx-auto"></i>
                            <span class="sr-only"></span>
                        </router-link>
                    </li>       
                </ul>
            </div>
            <admin-crud-sidenav 
                v-if="secondarySidenav === 'adminCrud'" 
                @hideSidenav="hideSidenav" />
            <base-sidenav 
                v-if="secondarySidenav === 'baseSidenav'" 
                @hideSidenav="hideSidenav" />
        </aside>
    </div>
</template>

<script>

    import { AdminCrudSidenav } from './partials/secondary-sidenav';
    import { BaseSidenav } from './partials/secondary-sidenav';
    
    export default {

        name: 'LeftSidebarComponent',

        components: {
            AdminCrudSidenav,
            BaseSidenav,
        },

        data() {
            return {
                secondarySidenav: '',
            }
        },

        methods: {
            toggleSidenav(sidenav) {
                if(this.secondarySidenav === sidenav) {
                    this.secondarySidenav = '';
                } else {
                    this.secondarySidenav = sidenav;
                }
            },

            hideSidenav() {
                this.secondarySidenav = '';
            },
        }
    }

</script>
