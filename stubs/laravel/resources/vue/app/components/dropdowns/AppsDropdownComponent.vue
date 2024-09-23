<template>
    <div>
        <!-- Apps -->
        <button 
            id="apps-dropdown-toggle"
            type="button" 
            data-dropdown-toggle="apps-dropdown" 
            class="p-2 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600 block lg:hidden">
            <span class="sr-only">{{__('Apps')}}</span>
            <!-- Icon -->
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
            </svg>
        </button>
        <!-- Dropdown menu -->
        <div 
            id="apps-dropdown"
            class="hidden overflow-x-auto h-96 z-50 my-4 max-w-sm text-base list-none bg-white rounded divide-y divide-gray-100 shadow-lg dark:bg-gray-700 dark:divide-gray-600 rounded-xl">
            <div class="block py-2 px-4 text-base font-medium text-center text-gray-700 bg-gray-50 dark:bg-gray-600 dark:text-gray-300">
                {{__('Apps')}} 
            </div>
            <div class="grid grid-cols-3 gap-4 p-4">
                <router-link 
                    :to="{
                        path: '/chat'
                    }" 
                    v-close-dropdown="{
                        dropdown: 'apps-dropdown',
                        trigger: 'apps-dropdown-toggle'
                    }"
                    class="block p-4 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 group">
                    <i class="fa-solid fa-inbox fa-lg p-4 mx-auto text-gray-900 dark:text-gray-400"></i>
                    <div class="text-sm text-gray-900 dark:text-white"> Chat </div>
                </router-link>
            </div>
        </div>
    </div>
</template>