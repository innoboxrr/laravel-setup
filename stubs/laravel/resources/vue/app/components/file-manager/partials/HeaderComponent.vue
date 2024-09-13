<template>
    <header class="w-full">
        <div class="relative z-10 flex h-16 flex-shrink-0 border-b border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="flex flex-1 justify-between px-4 sm:px-6">
                <div class="flex flex-1">
                    <form 
                        class="flex w-full md:ml-0" 
                        action="#" 
                        method="GET">
                        <div class="relative w-full text-gray-400 focus-within:text-gray-600 dark:text-gray-500 dark:focus-within:text-gray-300">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center dark:text-gray-300">
                                <MagnifyingGlassIcon 
                                    class="h-5 w-5 flex-shrink-0" 
                                    aria-hidden="true" />
                            </div>
                            <input 
                                name="mobile-search-field" 
                                id="mobile-search-field" 
                                class="h-full w-full border-0 py-2 pl-8 pr-3 text-base text-gray-900 focus:outline-none focus:ring-0 focus:placeholder:text-gray-400 dark:bg-gray-800 dark:text-gray-100 dark:focus:placeholder:text-gray-500 dark:placeholder:text-gray-300 sm:hidden" 
                                placeholder="Search file" 
                                type="search" />
                            <input 
                                name="desktop-search-field" 
                                id="desktop-search-field" 
                                class="hidden h-full w-full border-0 py-2 pl-8 pr-3 text-sm text-gray-900 focus:outline-none focus:ring-0 focus:placeholder:text-gray-400 dark:bg-gray-800 dark:text-gray-100 dark:focus:placeholder:text-gray-500 sm:block dark:placeholder:text-gray-300" 
                                placeholder="Search all files" 
                                type="search" />
                        </div>
                    </form>
                </div>
                <div
                    v-flowbite 
                    class="ml-2 flex items-center space-x-4 sm:ml-6 sm:space-x-6">
                    <button 
                        type="button" 
                        data-dropdown-toggle="fm-header-dropdown-menu" 
                        class="relative rounded-full bg-indigo-600 p-1.5 text-white hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:hover:bg-indigo-400">
                        <span class="absolute -inset-1.5" />
                        <PlusIcon class="h-5 w-5" aria-hidden="true" />
                        <span class="sr-only">Add file</span>
                    </button>
                    <div 
                        id="fm-header-dropdown-menu" 
                        class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                        <ul 
                            class="py-2 text-sm text-gray-700 dark:text-gray-200" 
                            aria-labelledby="dropdownDefaultButton">
                            <li>
                                <a 
                                    @click="$store.commit('fileManagerStore/OPEN_CREATE_DIRECTORY_MODAL')"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                    {{ __('Create Directory') }}
                                </a>
                            </li>
                            <li>
                                <a 
                                    @click="$store.commit('fileManagerStore/OPEN_UPLOAD_FILES_MODAL')" 
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                    {{ __('Upload Files') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Mobile toggle -->
                <button 
                    type="button" 
                    class="ml-3 p-3 lg:hidden" >
                    <span class="sr-only">Open main menu</span>
                    <Bars3Icon 
                        class="h-5 w-5 text-gray-900 dark:text-gray-200" 
                        aria-hidden="true" 
                        @click="toggleAsideMobilePanel"/>
                </button>
            </div>
        </div>
    </header>
</template>

<script>

    import { MagnifyingGlassIcon, PlusIcon } from '@heroicons/vue/20/solid'
    import { Bars3Icon } from '@heroicons/vue/20/solid'

    export default {
        components: {
            MagnifyingGlassIcon,
            PlusIcon,
            Bars3Icon
        },
        methods: {
            toggleAsideMobilePanel() {
                this.$store.commit('fileManagerStore/TOGGLE_ASIDE_MOBILE_PANEL');
            },
        }
    }

</script>