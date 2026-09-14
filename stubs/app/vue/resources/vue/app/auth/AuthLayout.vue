<template>

    <div class="auth-layout">

        <header class="auth-top">
            <RouterLink :to="{ name: 'site.home' }" class="auth-brand">{{ siteName }}</RouterLink>
            <ThemeToggle />
        </header>

        <main class="auth-main">
            <div class="fe-surface-raised auth-card">
                <RouterView />
            </div>
        </main>

    </div>

</template>

<script setup>

    import { computed } from 'vue'
    import { RouterLink, RouterView } from 'vue-router'
    import t from 'innoboxrr-i18n'
    import ThemeToggle from '@app/admin/components/ThemeToggle.vue'
    import { useOptionsStore } from '@app/stores/options.js'

    const options = useOptionsStore()

    const siteName = computed(() => options.option('site_name') || t('Home'))

</script>
