<template>

    <section class="site-section">

        <div class="site-container">

            <div class="site-join" :data-media="picture ? 'true' : 'false'">

                <img v-if="picture" :src="picture" alt="" class="site-media site-join-image" loading="lazy">

                <div>
                    <h2 v-if="filled(title)" class="site-title">{{ title }}</h2>
                    <p v-if="filled(subtitle)" class="site-lead">{{ subtitle }}</p>

                    <ul v-if="items.length" class="site-check-list site-join-features">
                        <li v-for="(feature, index) in items" :key="index">
                            <IconComponent name="success" :size="16" custom-class="site-check-icon" />
                            <span>{{ feature }}</span>
                        </li>
                    </ul>

                    <div v-if="filled(button_text)" class="site-actions">
                        <SiteLink :to="asText(button_link)" class="fe-button site-button-lg">
                            {{ button_text }} <span aria-hidden="true">→</span>
                        </SiteLink>
                    </div>
                </div>

            </div>

        </div>

    </section>

</template>

<script setup>

    import { computed } from 'vue'
    import { IconComponent } from 'innoboxrr-form-elements'
    import SiteLink from '../../../SiteLink.vue'
    import { asText, filled, imageUrl, textList } from '../../props.js'

    defineOptions({ inheritAttrs: false })

    const props = defineProps(['title', 'subtitle', 'image', 'features', 'button_text', 'button_link'])

    const picture = computed(() => imageUrl(props.image))

    const items = computed(() => textList(props.features))

</script>
