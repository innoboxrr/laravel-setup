<template>

    <main class="site site-empty">
        <div class="site-container site-narrow">
            <p class="site-subtitle">404</p>
            <h1 class="site-title">{{ t('Page not found') }}</h1>
            <p class="site-lead">{{ t('The page you are looking for does not exist or has moved.') }}</p>
            <div class="site-actions">
                <RouterLink :to="{ name: 'site.home' }" class="fe-button site-button-lg">{{ t('Go to the home page') }}</RouterLink>
                <RouterLink v-if="auth.authenticated" :to="{ name: 'admin.dashboard' }" class="site-link-arrow">
                    {{ t('Administrator') }} <span aria-hidden="true">→</span>
                </RouterLink>
            </div>
        </div>
    </main>

</template>

<script setup>

    import { RouterLink } from 'vue-router'
    import t from 'innoboxrr-i18n'
    import { useAuthStore } from '@app/stores/auth.js'

    const auth = useAuthStore()

</script>
