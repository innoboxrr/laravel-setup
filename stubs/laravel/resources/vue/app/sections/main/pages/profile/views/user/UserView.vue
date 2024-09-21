<template>
    <div>
        <h1 class="sr-only">Account Settings</h1>
        <header class="border-b border-white/5">
            <nav class="flex overflow-x-auto py-4">
                <ul 
                    role="list" 
                    class="flex min-w-full flex-none gap-x-6 px-4 text-sm font-semibold leading-6 text-gray-400 sm:px-6 lg:px-8">
                    <li 
                        v-for="item in navigationItems" 
                        :key="item.name">
                        <router-link 
                            :to="{
                                name: item.route
                            }"
                            :class="[
                                item.current ? 'text-indigo-400' : '',
                                'hover:text-indigo-400'
                            ]">
                            {{ item.name }}
                        </router-link>
                    </li>
                </ul>
            </nav>
        </header>
        <router-view />  
    </div>
</template>

<script>
    export default {
        name: 'UserView',
        data() {
            return {
                navigation: [
                    { 
                        id: 'edit-account', 
                        name: 'Edit account', 
                        route: 'ProfileUserEdit', 
                    },
                    {
                        id: 'advanced-settings',
                        name: 'Advanced settings',
                        route: 'ProfileUserAdvancedSettings',
                    },
                    { 
                        id: 'notifications', 
                        name: 'Notifications', 
                        route: 'ProfileUserNotifications', 
                    },
                    /*
                    { 
                        id: 'integrations', 
                        name: 'Integrations', 
                        route: 'ProfileUserIntegrations', 
                    },
                    {
                        id: 'security',
                        name: 'Security',
                        route: 'ProfileUserSecurity',
                    }
                    */
                ]
            }
        },
        computed: {
            navigationItems() {
                return this.navigation.map(item => ({
                    ...item,
                    current: this.$route.name === item.route || this.$route.meta.parent === item.route
                }));
            },
        }
    }
</script>