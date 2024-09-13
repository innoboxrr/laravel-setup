<template>
    <div class="flex items-center space-x-4 float-right">
        <div
            v-if="isLangSelected"
            class="flex items-center p-4 text-sm text-blue-800 border border-blue-300 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400 dark:border-blue-800"
            role="alert"
            style="max-width: 400px" >
            <svg
                class="flex-shrink-0 inline w-4 h-4 me-3"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                fill="currentColor"
                viewBox="0 0 20 20" >
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div>
                <span>
                    {{ __("You are translating this content to") }}
                    <strong
                        >{{ langs.find((l) => l.code === lang).name }}. <br
                    /></strong>
                    {{ __("Select none to edit the original content") }}
                </span>
            </div>
        </div>
        <div
            v-if="notBaseLang"
            class="flex items-center p-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800"
            role="alert"
            style="max-width: 400px" >
            <svg
                class="flex-shrink-0 inline w-4 h-4 me-3"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                fill="currentColor"
                viewBox="0 0 20 20" >
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div>
                <span>
                    {{ __("For translate this content you must set the site to base language") }}
                </span>
            </div>
        </div>
        <button
            v-if="!notBaseLang"
            v-flowbite
            id="dropdownMenuIconButton"
            data-dropdown-toggle="dropdownDots"
            class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
            type="button"
        >
            <svg
                class="w-6 h-6 text-gray-800 dark:text-white"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                fill="none"
                viewBox="0 0 24 24"
            >
                <path
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="m13 19 3.5-9 3.5 9m-6.125-2h5.25M3 7h7m0 0h2m-2 0c0 1.63-.793 3.926-2.239 5.655M7.5 6.818V5m.261 7.655C6.79 13.82 5.521 14.725 4 15m3.761-2.345L5 10m2.761 2.655L10.2 15"
                />
            </svg>
        </button>
        <!-- Dropdown menu -->
        <div
            id="dropdownDots"
            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600"
        >
            <ul
                class="py-2 text-sm text-gray-700 dark:text-gray-200"
                aria-labelledby="dropdownMenuIconButton"
            >
                <template v-for="lang in langs" :key="lang.code">
                    <li v-if="lang.code != appLang">
                        <a
                            @click="selectLanguage(lang.code)"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                        >
                            {{ lang.name }}
                        </a>
                    </li>
                </template>
            </ul>
            <div class="py-2">
                <a
                    @click="selectLanguage(null)"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                >
                    {{ __("English") }}
                </a>
            </div>
        </div>
    </div>
</template>
<script>
import { mapState } from "vuex";

export default {
    emits: ["changeLanguage"],
    data() {
        return {
            lang: this.$route.query.translate_to || null,
        };
    },
    mounted() {
        if (this.lang) {
            this.$emit("changeLanguage", this.lang);
        }
    },
    computed: {
        ...mapState("langStore", ["langs"]),

        isLangSelected() {
            return this.lang !== null;
        },
        notBaseLang() {
            return this.$store.state.langStore.lang?.code !== this.appLang;
        },
    },
    methods: {
        selectLanguage(lang) {
            if (!lang) {
                // Eliminar el lang del query params de la ruta
                const query = { ...this.$route.query };
                delete query.translate_to;
                this.$router.push({ query });
                this.$emit("changeLanguage", null);
                this.lang = null;
                return;
            }
            // Añadir el lang al query params de la ruta, junto con los otros query params
            this.$router.push({
                query: { ...this.$route.query, translate_to: lang },
            });
            this.lang = lang;
            this.$emit("changeLanguage", lang);
        },
    },
};
</script>
