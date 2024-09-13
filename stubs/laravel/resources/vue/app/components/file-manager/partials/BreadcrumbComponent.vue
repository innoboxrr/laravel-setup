<template>
    <nav class="flex px-4 sm:px-6 lg:px-8 pt-6" aria-label="Breadcrumb">
        <ol role="list" class="flex items-center space-x-4">
            <li>
                <div>
                    <a 
                        @click.prevent="setDirectoryFromPathIndex(0)"
                        class="text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400">
                        <HomeIcon 
                            class="h-5 w-5 flex-shrink-0" 
                            aria-hidden="true" />
                        <span class="sr-only">
                            Home
                        </span>
                    </a>
                </div>
            </li>
            <li 
                v-for="path, index in paths" 
                :key="path + '_' + index">
                <div class="flex items-center">
                    <svg class="h-5 w-5 flex-shrink-0 text-gray-300 dark:text-gray-600" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                        <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                    </svg>
                    <span  
                        v-if="paths.length - 1 === index"
                        class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                        {{ path }}
                    </span>
                    <a  
                        v-else
                        @click.prevent="setDirectoryFromPathIndex(index + 1)"
                        class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                        {{ path }}
                    </a>
                </div>
            </li>
        </ol>
    </nav>
</template>

<script>

    import { HomeIcon } from '@heroicons/vue/24/outline'

    export default {
        components: {
            HomeIcon
        },
        computed: {
            paths() {
                return this.$store.getters['fileManagerStore/getPaths'];
            }
        },
        methods: {
            setDirectoryFromPathIndex(path) {
                this.$store.dispatch('fileManagerStore/setDirectoryFromPathIndex', path);
            }
        }
    }
</script>