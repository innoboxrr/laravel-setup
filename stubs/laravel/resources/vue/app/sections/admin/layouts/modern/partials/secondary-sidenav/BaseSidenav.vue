<template>
    <div>
        <div
            v-flowbite
            id="base-sidenav"
            class="overflow-y-auto relative py-5 px-3 w-64 h-full bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700 uk-animation-slide-left"
        >
            <ul class="space-y-2 pt-12">
                <li>
                    <a
                        href="#"
                        class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                    >
                        <span class="ml-3">Overview</span>
                    </a>
                </li>
                <li>
                    <button
                        type="button"
                        class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                        aria-controls="dropdown-pages"
                        data-collapse-toggle="dropdown-pages"
                    >
                        <span class="flex-1 ml-3 text-left whitespace-nowrap"
                            >Pages</span
                        >
                        <i class="fa-solid fa-angle-down"></i>
                    </button>
                    <ul id="dropdown-pages" class="hidden py-2 space-y-2">
                        <li>
                            <a
                                href="#"
                                class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                >Settings</a
                            >
                        </li>
                        <li>
                            <a
                                href="#"
                                class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                >Kanban</a
                            >
                        </li>
                        <li>
                            <a
                                href="#"
                                class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                >Calendar</a
                            >
                        </li>
                    </ul>
                </li>
                <li>
                    <button
                        type="button"
                        class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                        aria-controls="dropdown-sales"
                        data-collapse-toggle="dropdown-sales"
                    >
                        <span class="flex-1 ml-3 text-left whitespace-nowrap"
                            >Sales</span
                        >
                        <i class="fa-solid fa-angle-down"></i>
                    </button>
                    <ul id="dropdown-sales" class="hidden py-2 space-y-2">
                        <li>
                            <a
                                href="#"
                                class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                >Products</a
                            >
                        </li>
                        <li>
                            <a
                                href="#"
                                class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                >Billing</a
                            >
                        </li>
                        <li>
                            <a
                                href="#"
                                class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                >Invoice</a
                            >
                        </li>
                    </ul>
                </li>
                <li>
                    <a
                        href="#"
                        class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                    >
                        <span class="flex-1 ml-3 whitespace-nowrap"
                            >Messages</span
                        >
                        <span
                            class="inline-flex justify-center items-center w-5 h-5 text-xs font-semibold rounded-full text-primary-800 bg-primary-100 dark:bg-primary-200 dark:text-primary-800"
                        >
                            6
                        </span>
                    </a>
                </li>
                <li>
                    <button
                        type="button"
                        class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                        aria-controls="dropdown-authentication"
                        data-collapse-toggle="dropdown-authentication"
                    >
                        <span class="flex-1 ml-3 text-left whitespace-nowrap"
                            >Authentication</span
                        >
                        <i class="fa-solid fa-angle-down"></i>
                    </button>
                    <ul
                        id="dropdown-authentication"
                        class="hidden py-2 space-y-2"
                    >
                        <li>
                            <a
                                href="#"
                                class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                >Sign In</a
                            >
                        </li>
                        <li>
                            <a
                                href="#"
                                class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                >Sign Up</a
                            >
                        </li>
                        <li>
                            <a
                                href="#"
                                class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                >Forgot Password</a
                            >
                        </li>
                    </ul>
                </li>
            </ul>
            <ul
                class="pt-5 mt-5 space-y-2 border-t border-gray-200 dark:border-gray-700"
            >
                <li>
                    <a
                        href="#"
                        class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group"
                    >
                        <span class="ml-3">Docs</span>
                    </a>
                </li>
                <li>
                    <a
                        href="#"
                        class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group"
                    >
                        <span class="ml-3">Components</span>
                    </a>
                </li>
                <li>
                    <a
                        href="#"
                        class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group"
                    >
                        <span class="ml-3">Help</span>
                    </a>
                </li>
            </ul>
            <div class="flex justify-end w-full bg-white dark:bg-gray-800">
                <button
                    type="button"
                    class="inline-flex p-2 text-gray-500 rounded-full cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white"
                    @click="$emit('hideSidenav')"
                >
                    <svg
                        class="w-6 h-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 19l-7-7 7-7"
                        ></path>
                    </svg>
                </button>
            </div>
        </div>
        <div class="overlay" @click="$emit('hideSidenav')"></div>
    </div>
</template>

<script>
export default {
    name: "SecondarySidenavComponent",

    emits: ["hideSidenav"],
};
</script>
