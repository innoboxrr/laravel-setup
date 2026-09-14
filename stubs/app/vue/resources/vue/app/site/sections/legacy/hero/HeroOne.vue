<template>

    <section class="site-hero">

        <div class="site-container site-hero-inner" :data-media="videoUrl ? 'true' : 'false'">

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

            <div v-if="videoUrl" class="site-hero-media">
                <video
                    :src="videoUrl"
                    class="site-media site-hero-video"
                    autoplay
                    muted
                    loop
                    playsinline
                    aria-hidden="true" />
            </div>

        </div>

    </section>

</template>

<script setup>

    import { computed } from 'vue'
    import { asText, imageList } from '../../props.js'
    import HeroCopy from './HeroCopy.vue'

    defineOptions({ inheritAttrs: false })

    const props = defineProps([
        'badge', 'badge_value', 'badge_link', 'title', 'message',
        'primary_button_text', 'primary_button_link', 'secondary_button_text', 'secondary_button_link',
        'videos',
    ])

    // Uno al azar, elegido una vez: si cambiara en cada repintado el vídeo
    // saltaría a otro mientras se ve.
    const seed = Math.random()

    const videoUrl = computed(() => {
        const videos = imageList(props.videos)

        return videos.length ? videos[Math.floor(seed * videos.length)] : null
    })

</script>
