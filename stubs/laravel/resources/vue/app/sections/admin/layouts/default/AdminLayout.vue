<template>

    <div v-flowbite class="antialiased bg-gray-50 dark:bg-gray-900">
        
        <!-- Topbar -->
        <topbar-component></topbar-component>
        
        <!-- Left Sidebar -->
        <left-sidebar-component></left-sidebar-component>
        
        <!-- Main Content -->
        <main class="bg-gray-50 dark:bg-gray-900 p-4 md:ml-64 lg:mr-16 pt-20" uk-height-viewport>

            <router-view></router-view>

        </main>

        <!--Right Sidebar-->
        <right-sidebar-component></right-sidebar-component>
        
    </div>

</template>

<script>

    import TopbarComponent from './TopbarComponent.vue';
    import LeftSidebarComponent from './LeftSidebarComponent.vue';
    import RightSidebarComponent from './RightSidebarComponent.vue';

    export default {

        components: {
            TopbarComponent,
            LeftSidebarComponent,
            RightSidebarComponent
        },

    }

</script>