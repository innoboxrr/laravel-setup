<template>

    <section class="site-section">

        <div class="site-container">

            <h2 v-if="filled(title)" class="site-title site-heading-center">{{ title }}</h2>

            <ul v-if="entries.length" class="site-partners">
                <li v-for="(partner, index) in entries" :key="index">
                    <SiteLink :to="partner.link" :new-tab="! isInternalLink(partner.link)" class="site-partner">
                        <img v-if="partner.logo" :src="partner.logo" :alt="partner.name" class="site-partner-logo" loading="lazy">
                        <span v-else class="site-partner-name">{{ partner.name }}</span>
                    </SiteLink>
                </li>
            </ul>

        </div>

    </section>

</template>

<script setup>

    import { computed } from 'vue'
    import SiteLink from '../../../SiteLink.vue'
    import { isInternalLink } from '../../../links.js'
    import { asArray, asObject, asText, filled, imageUrl } from '../../props.js'

    defineOptions({ inheritAttrs: false })

    const props = defineProps(['title', 'items'])

    // Sin logo se ve el nombre; sin logo ni nombre no hay nada que enseñar.
    const entries = computed(() => asArray(props.items)
        .map(asObject)
        .map((item) => ({ name: asText(item.name), logo: imageUrl(item.logo), link: asText(item.link) }))
        .filter((item) => item.logo || item.name.trim() !== ''))

</script>
