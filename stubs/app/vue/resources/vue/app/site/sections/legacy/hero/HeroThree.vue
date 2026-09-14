<template>

    <section class="site-hero">

        <div class="site-container site-hero-inner" data-media="true">

            <HeroCopy
                :badge="asText(badge)"
                :badge-value="asText(badge_value)"
                :badge-link="asText(badge_link)"
                :title="asText(title)"
                :message="asText(message)"
                :primary-text="asText(primary_button_text)"
                :primary-link="asText(primary_button_link)"
                :secondary-text="asText(secondary_button_text)"
                :secondary-link="asText(secondary_button_link)" />

            <!-- Una composición con los colores del tema en lugar de una foto:
                 no depende de ninguna imagen y sigue al modo oscuro. -->
            <div class="site-hero-art" aria-hidden="true">
                <span v-for="cell in 9" :key="cell" />
            </div>

        </div>

    </section>

</template>

<script setup>

    import { asText } from '../../props.js'
    import HeroCopy from './HeroCopy.vue'

    defineOptions({ inheritAttrs: false })

    defineProps([
        'badge', 'badge_value', 'badge_link', 'title', 'message',
        'primary_button_text', 'primary_button_link', 'secondary_button_text', 'secondary_button_link',
    ])

</script>
