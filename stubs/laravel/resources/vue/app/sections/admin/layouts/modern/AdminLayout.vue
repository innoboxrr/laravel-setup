<template>

    <div v-flowbite class="antialiased bg-slate-50 dark:bg-slate-900">

        <topbar-component></topbar-component>

        <left-sidebar-component></left-sidebar-component>

        <main class="bg-slate-50 dark:bg-slate-900 pt-15 px-0 md:px-15" uk-height-viewport>

            <router-view></router-view>

        </main>

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
