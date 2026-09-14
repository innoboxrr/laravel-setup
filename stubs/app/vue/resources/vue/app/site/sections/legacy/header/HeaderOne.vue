<template>

    <header class="site-header">

        <div class="site-container site-header-bar">

            <RouterLink :to="{ name: 'site.home' }" class="site-brand">
                <img v-if="logoUrl" :src="logoUrl" :alt="siteName" class="site-brand-logo">
                <span v-else class="site-brand-name">{{ siteName }}</span>
            </RouterLink>

            <button
                type="button"
                class="fe-icon-button site-header-toggle"
                :aria-expanded="open ? 'true' : 'false'"
                :aria-controls="panelId"
                :aria-label="open ? t('Close menu') : t('Open menu')"
                @click="open = ! open">
                <IconComponent :name="open ? 'close' : 'menu'" />
            </button>

            <div :id="panelId" class="site-header-panel" :data-open="open ? 'true' : 'false'">

                <nav v-if="links.length" :aria-label="t('Main navigation')">
                    <ul class="site-header-links">
                        <li v-for="(item, index) in links" :key="index">
                            <SiteLink :to="item.link" class="site-header-link" @click="open = false">{{ item.label }}</SiteLink>
                        </li>
                    </ul>
                </nav>

                <ul v-if="socials.length" class="site-social" :aria-label="t('Social networks')">
                    <li v-for="item in socials" :key="item.id">
                        <a :href="item.href" class="fe-icon-button" target="_blank" rel="noopener noreferrer" :aria-label="item.label">
                            <IconComponent :name="item.icon" :size="16" />
                        </a>
                    </li>
                </ul>

                <RouterLink
                    v-if="auth.authenticated"
                    :to="{ name: 'admin.dashboard' }"
                    class="fe-button fe-button-sm site-header-cta">{{ t('Administrator') }}</RouterLink>

                <RouterLink
                    v-else
                    :to="{ name: 'auth.login' }"
                    class="fe-button fe-button-sm site-header-cta">{{ t('Sign in') }}</RouterLink>

            </div>

        </div>

    </header>

</template>

<script setup>

    import { computed, ref, useId } from 'vue'
    import { RouterLink } from 'vue-router'
    import t from 'innoboxrr-i18n'
    import { IconComponent } from 'innoboxrr-form-elements'
    import { useAuthStore } from '@app/stores/auth.js'
    import { useOptionsStore } from '@app/stores/options.js'
    import SiteLink from '../../../SiteLink.vue'
    import { asArray, asObject, asText, filled, imageUrl } from '../../props.js'
    import { socialLinks } from '../../social.js'

    defineOptions({ inheritAttrs: false })

    const props = defineProps(['logo', 'nav', 'facebook', 'twitter', 'instagram', 'youtube', 'whatsapp', 'linkedin', 'tiktok'])

    const auth = useAuthStore()
    const options = useOptionsStore()

    const open = ref(false)
    const panelId = useId()

    const siteName = computed(() => asText(options.option('site_name', '')))

    const logoUrl = computed(() => imageUrl(props.logo))

    const links = computed(() => asArray(props.nav)
        .map(asObject)
        .filter((item) => filled(item.label))
        .map((item) => ({ label: asText(item.label), link: asText(item.link) })))

    const socials = computed(() => socialLinks(props))

</script>
