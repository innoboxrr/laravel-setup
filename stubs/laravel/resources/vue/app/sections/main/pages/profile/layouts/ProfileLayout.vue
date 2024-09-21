<template>
    <div v-if="user">
        <TransitionRoot 
            as="template" 
            :show="sidebarOpen">
            <Dialog 
                class="relative z-50 xl:hidden" 
                @close="sidebarOpen = false">
                <TransitionChild 
                    as="template" 
                    enter="transition-opacity ease-linear duration-300" 
                    enter-from="opacity-0" 
                    enter-to="opacity-100" 
                    leave="transition-opacity ease-linear duration-300" 
                    leave-from="opacity-100" 
                    leave-to="opacity-0">
                    <div class="fixed inset-0 bg-gray-900/80"></div> 
                </TransitionChild>
                <div class="fixed inset-0 flex">
                    <TransitionChild 
                        as="template" 
                        enter="transition ease-in-out duration-300 transform" 
                        enter-from="-translate-x-full" 
                        enter-to="translate-x-0" 
                        leave="transition ease-in-out duration-300 transform" 
                        leave-from="translate-x-0" 
                        leave-to="-translate-x-full">
                        <DialogPanel class="relative mr-16 flex w-full max-w-xs flex-1">
                            <TransitionChild 
                                as="template" 
                                enter="ease-in-out duration-300" 
                                enter-from="opacity-0" 
                                enter-to="opacity-100" 
                                leave="ease-in-out duration-300" 
                                leave-from="opacity-100" 
                                leave-to="opacity-0">
                                <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                                    <button 
                                        type="button" 
                                        class="-m-2.5 p-2.5" 
                                        @click="sidebarOpen = false">
                                        <span class="sr-only">Close sidebar</span>
                                        <XMarkIcon class="h-6 w-6 text-white" aria-hidden="true" />
                                    </button>
                                </div>
                            </TransitionChild>
                            <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-gray-100 dark:bg-gray-900 px-6 ring-1 ring-white/10">
                                <div class="flex h-16 shrink-0 items-center">
                                    <img 
                                        class="h-8 w-auto" 
                                        :src="icon96x96" 
                                        :alt="appName" />
                                </div>
                                <nav class="flex flex-1 flex-col">
                                    <ul role="list" class="flex flex-1 flex-col gap-y-7">
                                        <li>
                                            <ul 
                                                role="list" 
                                                class="-mx-2 space-y-1">
                                                <li 
                                                    v-for="item in navigationItems" 
                                                    :key="item.name">
                                                    <router-link 
                                                        :to="{
                                                            name: item.route
                                                        }"
                                                        :class="[
                                                            item.current ? 'bg-gray-800 text-white' : 'text-gray-700 dark:text-gray-400 hover:text-white hover:bg-gray-800', 
                                                            'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold'
                                                        ]">
                                                        <component 
                                                            :is="item.icon" 
                                                            class="h-6 w-6 shrink-0" 
                                                            aria-hidden="true" />
                                                        {{ item.name }}
                                                    </router-link>  
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <div class="text-xs font-semibold leading-6 text-gray-400">
                                                {{ __('Your products') }}
                                            </div>
                                            <ul role="list" class="-mx-2 mt-2 space-y-1">
                                                <li 
                                                    v-for="product in products" 
                                                    :key="product.name">
                                                    <router-link
                                                        :to="{
                                                            name: product.route
                                                        }"
                                                        :class="[
                                                            product.current ? 'bg-gray-800 text-white' : 'text-gray-600 dark:text-gray-400 hover:text-white hover:bg-gray-800', 
                                                            'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold'
                                                        ]"
                                                        aria-hidden="true"
                                                        @click="sidebarOpen = false">
                                                        <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border border-gray-700 bg-gray-800 text-[0.625rem] font-medium text-gray-300 group-hover:text-white">
                                                            {{ product.initial }}
                                                        </span>
                                                        <span class="truncate">
                                                            {{ product.name }}
                                                        </span>
                                                    </router-link>
                                                </li>
                                            </ul>
                                        </li>
                                        <!-- Para ir al perfil público-->
                                        <li class="-mx-6 mt-auto">
                                            <a 
                                                href="#" 
                                                class="flex items-center gap-x-4 px-6 py-3 text-sm font-semibold leading-6 text-gray-700 dark:text-gray-200 hover:bg-gray-800">
                                                <img 
                                                    class="h-8 w-8 rounded-full bg-gray-800" 
                                                    :src="user.avatar_url" 
                                                    alt="" />
                                                <span class="sr-only">Your profile</span>
                                                <span aria-hidden="true">
                                                    {{ user.name }}
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </Dialog>
        </TransitionRoot>
        <div class="hidden xl:fixed xl:inset-y-0 xl:z-30 xl:flex xl:w-72 xl:flex-col">
            <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-gray-100 dark:bg-black/10 px-6 ring-1 ring-white/5">
                <div class="flex h-16 shrink-0 items-center">
                <img 
                    class="h-8 w-auto" 
                    :src="icon96x96"  
                    :alt="appName" />
                </div>
                <nav class="flex flex-1 flex-col">
                    <ul 
                        role="list" 
                        class="flex flex-1 flex-col gap-y-7">
                        <li>
                            <ul 
                                role="list" 
                                class="-mx-2 space-y-1">
                                <li 
                                    v-for="item in navigationItems" 
                                    :key="item.name">
                                    <router-link 
                                        :to="{
                                            name: item.route
                                        }"
                                        :class="[
                                            item.current ? 'bg-gray-800 text-white' : 'text-gray-600 dark:text-gray-400 hover:text-white hover:bg-gray-800', 
                                            'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold'
                                        ]">
                                        <component 
                                            :is="item.icon" 
                                            class="h-6 w-6 shrink-0" 
                                            aria-hidden="true" />
                                        {{ item.name }}
                                    </router-link>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <div class="text-xs font-semibold leading-6 text-gray-400">
                                {{ __('Your products') }}
                            </div>
                            <ul 
                                role="list" 
                                class="-mx-2 mt-2 space-y-1">
                                <li 
                                    v-for="product in productItems" 
                                    :key="product.name"
                                    aria-hidden="true"
                                    @click="sidebarOpen = false">
                                    <router-link
                                        :to="{
                                            name: product.route
                                        }"
                                        :class="[
                                            product.current ? 'bg-gray-800 text-white' : 'text-gray-600 dark:text-gray-400 hover:text-white hover:bg-gray-800', 
                                            'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold'
                                        ]">
                                        <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border border-gray-700 bg-gray-800 text-[0.625rem] font-medium text-gray-300 group-hover:text-white">
                                            {{ product.initial }}
                                        </span>
                                        <span class="truncate">
                                            {{ product.name }}
                                        </span>
                                    </router-link>
                                </li>
                            </ul>
                        </li>
                        <li class="-mx-6 mt-auto">
                            <router-link 
                                :to="{
                                    name: 'ProfileUserShow',
                                    params: {
                                        user_id: user.id
                                    }
                                }" 
                                aria-hidden="true"
                                class="flex items-center gap-x-4 px-6 py-3 text-sm font-semibold leading-6 text-gray-600 dark:text-gray-400 hover:bg-gray-800"
                                @click="sidebarOpen = false">
                                <img 
                                    class="h-8 w-8 rounded-full bg-gray-800" 
                                    :src="user.avatar_url" 
                                    :alt="user.name" />
                                <span class="sr-only">
                                    {{ __('Your public profile') }}
                                </span>
                                <span aria-hidden="true">
                                    {{ user.name }}    
                                </span>
                            </router-link>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="xl:pl-72">
            <div 
                class="sticky top-0 z-30 flex shrink-0 items-center gap-x-6 border-b border-white/5 bg-gray-100 dark:bg-gray-900 px-4 shadow-sm sm:px-6 lg:px-8 h-14"
                :class="{
                    'md:h-16' : showSearch,
                    'md:h-2': !showSearch
                }">
                <button 
                    type="button" 
                    class="-m-2.5 p-2.5 dark:text-white text-gray-600 xl:hidden" 
                    @click="sidebarOpen = true">
                    <span class="sr-only">Open sidebar</span> 
                    <Bars3Icon class="h-5 w-5" aria-hidden="true" />
                </button>
                <div v-if="showSearch" class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
                    <form class="flex flex-1" action="#" method="GET">
                        <label for="search-field" class="sr-only">Search</label>
                        <div class="relative w-full">
                            <MagnifyingGlassIcon 
                                class="pointer-events-none absolute inset-y-0 left-0 h-full w-5 text-gray-500" 
                                aria-hidden="true" />
                            <input 
                                id="search-field" 
                                class="block h-full w-full border-0 bg-transparent py-0 pl-8 pr-0 text-gray-600 dark:text-white focus:ring-0 sm:text-sm" 
                                placeholder="Search in my profile ..." 
                                type="search" 
                                name="search" />
                        </div>
                    </form>
                </div>
            </div>
            <main>
                <router-view />
            </main>
        </div>
    </div>
</template>

<script setup>
    import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue'
    import {
        UserIcon,
        ShoppingCartIcon,
        ShoppingBagIcon,
        HeartIcon,
        StarIcon ,
        XMarkIcon,
        CogIcon,
        CurrencyDollarIcon,
    } from '@heroicons/vue/24/outline'
    import { Bars3Icon, MagnifyingGlassIcon } from '@heroicons/vue/20/solid'
</script>

<script>

import { mapState } from 'vuex';

export default {

    data() {

        return {
            sidebarOpen: false,
            showSearch: false, // Cambiar para habilitar el buscador en el navegador
            navigation: [
                { 
                    name: 'Profile', 
                    route: 'ProfileUser', 
                    icon: UserIcon, 
                },
                { 
                    name: 'Carts', 
                    route: 'ProfileCart', 
                    icon: ShoppingCartIcon, 
                },
                { 
                    name: 'Payments', 
                    route: 'ProfilePayment', 
                    icon: ShoppingBagIcon
                },
                { 
                    name: 'Payouts', 
                    route: 'ProfilePayout', 
                    icon: CurrencyDollarIcon
                },
                { 
                    name: 'Benefits', 
                    route: 'ProfileBenefit', 
                    icon: StarIcon 
                },
                { 
                    name: 'Wishlist', 
                    route: 'ProfileWishlist', 
                    icon: HeartIcon
                },
                // { name: 'Settings', route: '#', icon: CogIcon},
                // Add more items here
            ],
            products: [
                { 
                    id: 1, 
                    name: 'Courses', 
                    route: 'ProfileProductCourse', 
                    initial: 'C'
                },
                { 
                    id: 2, 
                    name: 'Exams', 
                    route: 'ProfileProductTestkin', 
                    initial: 'E'
                },
                { 
                    id: 3, 
                    name: 'Vouchers', 
                    route: 'ProfileProductVoucher', 
                    initial: 'V'
                },
                { 
                    id: 4, 
                    name: 'Quizzes', 
                    route: 'ProfileProductQuiz', 
                    initial: 'Q'
                },
                /*
                { 
                    id: 1, 
                    name: 'Packages', 
                    route: 'ProfileProductPackage', 
                    initial: 'P'
                },
                */
            ],
        }

    },

    computed: {
        ...mapState('authPages', ['user']),

        navigationItems() {
            return this.navigation.map(item => ({
                ...item,
                current: this.$route.name === item.route || this.$route.meta.parent === item.route
            }));
        },

        productItems() {
            return this.products.map(product => ({
                ...product,
                current: this.$route.name === product.route || this.$route.meta.parent === product.route
            }));
        },
    },

}

</script>

