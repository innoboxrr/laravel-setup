<template>

    <section class="site-hero">

        <div class="site-container site-hero-inner" :data-media="columns.length ? 'true' : 'false'">

            <HeroCopy
                :badge="asText(badge)"
                :badge-value="asText(badge_value)"
                :badge-link="asText(badge_link)"
                :badge-value-link="asText(badge_value_link)"
                :title="asText(title)"
                :message="asText(message)"
                :primary-text="asText(primary_button_text)"
                :primary-link="asText(primary_button_link)"
                :secondary-text="asText(secondary_button_text)"
                :secondary-link="asText(secondary_button_link)">

                <template v-if="canPlay && ! columns.length" #actions>
                    <button type="button" class="fe-button-secondary site-button-lg" @click="playing = true">
                        <IconComponent name="mdi:play" />
                        {{ playText }}
                    </button>
                </template>

            </HeroCopy>

            <div v-if="columns.length" class="site-hero-columns-wrap">

                <div class="site-hero-columns" aria-hidden="true">
                    <ul
                        v-for="(column, index) in columns"
                        :key="index"
                        class="site-hero-column"
                        :data-direction="index % 2 === 1 ? 'down' : 'up'">
                        <!-- La lista va dos veces para que el desplazamiento
                             no se corte al volver a empezar. -->
                        <li v-for="(src, position) in [...column, ...column]" :key="position">
                            <img :src="src" alt="" class="site-media" loading="lazy">
                        </li>
                    </ul>
                </div>

                <button v-if="canPlay" type="button" class="site-play" @click="playing = true">
                    <IconComponent name="mdi:play" />
                    {{ playText }}
                </button>

            </div>

        </div>

        <DialogComponent
            v-if="canPlay"
            v-model:open="playing"
            :title="playText"
            :close-label="t('Close')"
            size="lg">
            <video v-if="playing" :src="videoUrl" class="site-video" controls autoplay playsinline />
        </DialogComponent>

    </section>

</template>

<script setup>

    import { computed, ref } from 'vue'
    import t from 'innoboxrr-i18n'
    import { DialogComponent, IconComponent } from 'innoboxrr-form-elements'
    import { asText, filled, imageList, imageUrl, isTruthy } from '../../props.js'
    import HeroCopy from './HeroCopy.vue'

    defineOptions({ inheritAttrs: false })

    const props = defineProps([
        'badge', 'badge_value', 'badge_link', 'badge_value_link', 'title', 'message',
        'primary_button_text', 'primary_button_link', 'secondary_button_text', 'secondary_button_link',
        'video', 'display_play_button', 'play_button_text', 'imgs_1', 'imgs_2', 'imgs_3',
    ])

    const playing = ref(false)

    const columns = computed(() => [props.imgs_1, props.imgs_2, props.imgs_3]
        .map((list) => imageList(list))
        .filter((list) => list.length > 0))

    const videoUrl = computed(() => imageUrl(props.video))

    const canPlay = computed(() => Boolean(videoUrl.value) && isTruthy(props.display_play_button))

    const playText = computed(() => (filled(props.play_button_text) ? asText(props.play_button_text) : t('Play video')))

</script>
