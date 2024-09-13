<template>
    <div v-if="lang" v-flowbite>
        <button
            type="button"
            data-dropdown-toggle="language-dropdown"
            class="inline-flex items-center text-gray-700 dark:text-slate-100 dark:hover:bg-slate-900 focus:ring-4 focus:ring-blue-400 font-medium rounded-lg text-sm px-2 lg:px-4 py-2 lg:py-2.5 mr-2 md:mr-3 dark:hover:bg-slate-700 focus:outline-none dark:focus:ring-slate-800">
            <country-flag 
                :key="lang.country_code"
                class="w-4 h-4 rounded-full mr-2" 
                :country-code="lang.country_code" />
            <span class="hidden mr-2 md:inline dark:text-gray-100">
                {{ lang.name }}
            </span>
            <svg class="hidden w-4 h-4 md:inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </button>
        <!-- Dropdown -->
        <div
            class="hidden z-50 my-4 w-48 text-base list-none rounded divide-y divide-slate-100 shadow bg-white dark:bg-slate-800"
            id="language-dropdown">
            <ul class="py-1" role="none">
                <li 
                    v-for="ln in langs"
                    :key="ln.id">
                    <a 
                        @click="setLang({
                            lang: ln,
                            refresh: true
                        })"
                        class="block py-2 px-4 text-sm dark:text-slate-100 text-slate-700 hover:bg-slate-900 hover:text-white" role="menuitem">
                        <div class="inline-flex items-center">
                            <country-flag 
                                class="w-4 h-4 rounded-full mr-2" 
                                :country-code="ln.country_code" />
                            {{ ln.name }} ({{ ln.country_code }})
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    import { mapState, mapActions } from 'vuex';
    export default {
        computed: {
            ...mapState('langStore', [
                'langs',
                'lang'
            ]),
        },
        methods: {
            ...mapActions('langStore', [
                'setLang'
            ]),
        }
    }
</script>