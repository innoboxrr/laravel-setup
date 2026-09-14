<template>

    <section class="site-section">

        <div class="site-container site-split" :data-media="pictures.length ? 'true' : 'false'">

            <div>
                <h2 v-if="filled(title)" class="site-title">{{ title }}</h2>
                <p v-if="filled(subtitle)" class="site-subtitle">{{ subtitle }}</p>
                <p v-if="filled(message)" class="site-text">{{ message }}</p>
                <div v-if="filled(button_text)" class="site-actions">
                    <SiteLink :to="asText(button_link)" class="fe-button site-button-lg">
                        {{ button_text }} <span aria-hidden="true">→</span>
                    </SiteLink>
                </div>
            </div>

            <div v-if="pictures.length" class="site-mosaic" :data-count="pictures.length">
                <img v-for="(src, index) in pictures" :key="index" :src="src" alt="" class="site-media" loading="lazy">
            </div>

        </div>

    </section>

</template>

<script setup>

    import { computed } from 'vue'
    import SiteLink from '../../../SiteLink.vue'
    import { asText, filled, imageList } from '../../props.js'

    defineOptions({ inheritAttrs: false })

    const props = defineProps(['title', 'subtitle', 'message', 'button_text', 'button_link', 'images'])

    const pictures = computed(() => imageList(props.images, 4))

</script>
