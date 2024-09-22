<template>
    <div class="flex min-h-screen flex-1">
        <div class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
            <router-view></router-view>
        </div>
        <div class="relative hidden w-0 flex-1 lg:block">
            <img
                class="absolute inset-0 h-full w-full object-cover"
                :src="option('login.image', 'https://placehold.co/1920x1080')"
                :alt="appName" />
        </div>
    </div>
</template>

<script>
    export default {
        name: "AuthLayout",
    }
</script>
