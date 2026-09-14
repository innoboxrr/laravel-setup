<template>

    <footer class="site-footer">

        <div class="site-container">

            <div class="site-footer-top">

                <div class="site-footer-brand">
                    <RouterLink :to="{ name: 'site.home' }" class="site-brand">
                        <img v-if="logoUrl" :src="logoUrl" :alt="siteName" class="site-brand-logo">
                        <span v-else class="site-brand-name">{{ siteName }}</span>
                    </RouterLink>
                    <p v-if="filled(description)" class="site-text">{{ description }}</p>
                </div>

                <nav v-if="columns.length" class="site-footer-cols" :aria-label="t('Footer')">
                    <div v-for="(column, index) in columns" :key="index">
                        <h2 v-if="column.title" class="site-footer-heading">{{ column.title }}</h2>
                        <ul class="site-footer-links">
                            <li v-for="(item, position) in column.items" :key="position">
                                <SiteLink :to="item.link">{{ item.name }}</SiteLink>
                            </li>
                        </ul>
                    </div>
                </nav>

            </div>

            <div v-if="letter.title || letter.buttonText" class="site-footer-newsletter">
                <div>
                    <h2 v-if="letter.title" class="site-footer-heading">{{ letter.title }}</h2>
                    <p v-if="letter.subtitle" class="site-text">{{ letter.subtitle }}</p>
                </div>
                <SiteLink v-if="letter.buttonText" :to="letter.buttonLink" class="fe-button">{{ letter.buttonText }}</SiteLink>
            </div>

            <div class="site-footer-bottom">
                <p class="site-footer-copy">© {{ year }} {{ siteName }}. {{ t('All rights reserved.') }}</p>
                <ul v-if="socials.length" class="site-social" :aria-label="t('Social networks')">
                    <li v-for="item in socials" :key="item.id">
                        <a :href="item.href" class="fe-icon-button" target="_blank" rel="noopener noreferrer" :aria-label="item.label">
                            <IconComponent :name="item.icon" :size="16" />
                        </a>
                    </li>
                </ul>
            </div>

        </div>

    </footer>

</template>

<script setup>

    import { computed } from 'vue'
    import { RouterLink } from 'vue-router'
    import t from 'innoboxrr-i18n'
    import { IconComponent } from 'innoboxrr-form-elements'
    import { useOptionsStore } from '@app/stores/options.js'
    import SiteLink from '../../../SiteLink.vue'
    import { asArray, asObject, asText, filled, imageUrl } from '../../props.js'
    import { socialLinks } from '../../social.js'

    defineOptions({ inheritAttrs: false })

    const props = defineProps(['logo', 'description', 'cols', 'newsletter', 'social_links'])

    const options = useOptionsStore()

    const year = new Date().getFullYear()

    const siteName = computed(() => asText(options.option('site_name', '')))

    const logoUrl = computed(() => imageUrl(props.logo))

    const columns = computed(() => asArray(props.cols)
        .map(asObject)
        .map((column) => ({
            title: asText(column.title),
            items: asArray(column.items)
                .map(asObject)
                .filter((item) => filled(item.name))
                .map((item) => ({ name: asText(item.name), link: asText(item.link) })),
        }))
        .filter((column) => column.title || column.items.length))

    const letter = computed(() => {
        const value = asObject(props.newsletter)

        return {
            title: asText(value.title),
            subtitle: asText(value.subtitle),
            buttonText: asText(value.button_text),
            buttonLink: asText(value.button_link),
        }
    })

    const socials = computed(() => socialLinks(props.social_links))

</script>
