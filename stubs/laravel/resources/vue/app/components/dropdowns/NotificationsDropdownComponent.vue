<template>
    <div>
            <!-- Notifications -->
        <button
            type="button"
            data-dropdown-toggle="notification-dropdown"
            class="relative p-2 mr-1 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
            @click="loadNotifications">
            <span class="sr-only">View notifications</span>
            <!-- Bell icon -->
            <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path>
            </svg>
            <div v-if="unreadNotifications > 0" class="absolute block w-3 h-3 bg-red-500 border-2 border-white rounded-full top-0.5 start-5 dark:border-gray-900"></div>
        </button>

        <!-- Dropdown menu -->
        <div
            class="hidden overflow-hidden z-50 my-4  text-base list-none bg-white rounded divide-y divide-gray-100 shadow-lg dark:divide-gray-600 dark:bg-gray-700 rounded-xl w-96 dark:text-gray-300"
            id="notification-dropdown">

            <div class="block py-2 px-4 text-base font-medium text-center text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                Notificaciones
            </div>

            <div class="h-96 overflow-auto hide-scrollbar">

                <a
                    v-for="notification in notifications"
                    :key="notification.id"
                    @click="openNotification(notification)"
                    :href="'/' + notification.data.action"
                   class="flex py-3 px-4 border-b hover:bg-gray-100 dark:hover:bg-gray-600 dark:border-gray-500 hover:no-underline w-96"
                    :class="{
                        'bg-gray-100 dark:bg-gray-600': notification.read_at === null
                    }">
                    <div class="flex-shrink-0 relative">
                        <img
                            class="w-11 h-11 rounded-full"
                            :src="notification.data.img"
                             :alt="notification.data.from_name" />
                        <div
                            class="flex absolute justify-center items-center ml-6 -mt-5 w-5 h-5 bg-green-400 rounded-full border border-white dark:border-gray-700">
                            <svg aria-hidden="true" class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M18 13V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2zM5 7a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h3a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="pl-3 w-full">
                        <div
                            class="text-gray-500 font-normal text-sm mb-1.5 dark:text-gray-100"
                            v-html="notification.data.message"></div>
                        <div class="text-xs font-medium text-primary-600 dark:text-slate-400">
                            {{ fromNow(notification.created_at) }}
                        </div>
                    </div>
                </a>

                <div v-if="notifications.length === 0" class="block py-12 text-center">
                    <span class="text-lg font-light text-gray-800 dark:text-gray-200 mt-8">
                        {{ __('There are no notifications') }}
                    </span>
                    <div class="text-4xl text-gray-300 dark:text-gray-600 py-8">
                        &#x1F4AC; <!-- Emoji de burbuja de diálogo -->
                    </div>

                    <!-- Botón para recargar notificaciones -->
                    <button
                        @click="loadNotifications"
                        class="inline-flex items-center gap-x-1.5 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        <i 
                            :class="[
                                'fas fa-sync-alt mr-2',
                                isLoading ? 'animate-spin' : ''
                            ]"></i>
                        {{ __('Reload notifications') }}
                    </button>
                </div>
            </div>
            <a
                @click="clearNotifications"
                class="block py-2 text-md font-medium text-center text-gray-900 bg-gray-50 hover:bg-gray-100 dark:bg-gray-700 dark:text-white dark:hover:underline">
                <div class="inline-flex items-center">
                    <i class="fas fa-trash-alt mr-2 text-red-500 dark:text-red-400"></i>
                    <span class="text-light">
                        {{ __('Clear all') }}
                    </span>
                </div>
            </a>

        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                isLoading: false,
                interval: null,
                notifications: [],
                unreadNotifications: 0,
            }
        },

        mounted() {
            this.loadNotifications();
            // Iniciar el intervalo para cargar notificaciones cada 30 segundos
            /*
            this.interval = setInterval(() => {
                this.checkUnreadNotifications();
            }, 30000);
            */
        },

        beforeDestroy() {
            // Limpiar el intervalo cuando el componente se destruya
            // clearInterval(this.interval);
        },

        methods: {
            loadNotifications() {
                this.isLoading = true;
                this.$httpRequest('get', route('innoboxrr.notifications.index'), {
                    loader: false,
                }) // This is a custom method that I created to make HTTP requests
                    .then(response => {
                        this.notifications = response;
                        this.updateUnreadNotificationsCount();
                        setTimeout(() => {
                            this.isLoading = false;
                        }, 1000);
                    })
                    .catch(error => {
                        console.log(error)
                    })
            },
            checkUnreadNotifications() {
                this.loadNotifications();
            },
            updateUnreadNotificationsCount() {
                this.unreadNotifications = this.notifications.filter(notification => notification.read_at === null).length;
            },
            openNotification(notification) {
                this.$httpRequest('post', route('innoboxrr.notifications.mark.as.read', notification.id), {
                    loader: false
                })
                .then(response => {
                    notification.read_at = new Date().toISOString(); // Simular la marca de tiempo de lectura
                    this.updateUnreadNotificationsCount();
                })
                .catch(error => {
                    console.log(error);
                })
            },

            clearNotifications() {
                this.$httpRequest('delete', route('innoboxrr.notifications.delete.all'), {
                    loader: false,
                })
                    .then(response => {
                        this.notifications = [];
                        this.unreadNotifications = 0;
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
        }
    }
</script>

<style scoped>
    /* Añade tu clase de animación si no estás usando las de Tailwind */
    .animate-spin {
    animation: spin 1s linear infinite;
    }
    @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
    }
</style>