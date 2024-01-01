<template>

    <div>

        <button 
            class="inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5" 
            type="button">
            
            <span class="sr-only">Open dropdown</span>

            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 3">

                <path d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"/>

            </svg>

        </button>

        <!-- Dropdown menu -->
        <div 
            uk-dropdown="mode: click;"
            class="uk-padding-remove z-10 hidden text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">

            <ul class="py-2" aria-labelledby="dropdownButton">

                <li v-for="item in items" :key="item.label">

                    <router-link
                        v-if="item.type === 'router'"
                        :to="item.to" 
                        :class="item.class ?? defaultClass">

                        <span v-html="item.label"></span>

                    </router-link>

                    <a 
                        v-else-if="item.type === 'link'"
                        :href="item.link"
                        :class="item.class ?? defaultClass">

                        <span v-html="item.label"></span>

                    </a>

                    <a 
                        v-else-if="item.type === 'event'"
                        @click.prevent="handleEvent(item.event, item.params)"
                        :class="item.class ?? defaultClass">

                        <span v-html="item.label"></span>

                    </a>

                </li>

            </ul>

        </div>

    </div>

</template>

<script>

    /**
     * items: [
     *   { 
     *      type: 'link|router|event', 
     *      to: {}, // if type is router
     *      link: '', // if type is link 
     *      event: '', // if type is event
     *      label: 'Allow HTML', 
     *   }
     * ]
    */

    export default {

        props: {
            items: {
                type: Array,
                required: true
            }
        },

        data() {
            return {
                defaultClass: 'uk-link-reset block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100'
            }
        },

        methods: {
            handleEvent(method, params = null) {
                if(typeof method === 'function') {
                    method(params);
                }
            },
        }

    }

</script>