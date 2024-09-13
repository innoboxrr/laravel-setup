<template>
    <div>
        <h1 class="sr-only">Account Settings</h1>
        <header class="border-b border-white/5">
            <nav class="flex overflow-x-auto py-4">
                <ul 
                    role="list" 
                    class="flex min-w-full flex-none gap-x-6 px-4 text-sm font-semibold leading-6 text-gray-400 sm:px-6 lg:px-8">
                    <li 
                        v-for="item in secondaryNavigation" 
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
                secondaryNavigation: [
                    { 
                        id: 'my-courses', 
                        name: 'My courses', 
                        route: 'ProfileProductCourse', 
                    },
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