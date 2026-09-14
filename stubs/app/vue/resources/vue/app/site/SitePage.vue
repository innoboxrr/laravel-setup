<template>

    <ThemeManager v-if="page" :page="page" />

    <main v-else class="site site-empty">
        <div class="site-container site-narrow">
            <h1 class="site-title">{{ t('This page has no content yet') }}</h1>
            <p class="site-lead">{{ t('An administrator can add it from the site editor.') }}</p>
            <div class="site-actions">
                <RouterLink :to="{ name: 'site.home' }" class="fe-button site-button-lg">{{ t('Go to the home page') }}</RouterLink>
            </div>
        </div>
    </main>

</template>

<script setup>

    import { computed } from 'vue'
    import { RouterLink, useRoute } from 'vue-router'
    import t from 'innoboxrr-i18n'
    import { useOptionsStore } from '@app/stores/options.js'
    import ThemeManager from './ThemeManager.vue'

    const route = useRoute()
    const options = useOptionsStore()

    const page = computed(() => {
        const value = options.option(`theme.${route.meta.page}`)

        return value && typeof value === 'object' && ! Array.isArray(value) ? value : null
    })

</script>
