<template>

    <section class="site-section site-section-alt">

        <div class="site-container site-narrow">

            <div v-if="filled(title) || filled(subtitle)" class="site-heading-center">
                <h2 v-if="filled(title)" class="site-title">{{ title }}</h2>
                <p v-if="filled(subtitle)" class="site-lead">{{ subtitle }}</p>
            </div>

            <!-- <details> ya es un acordeón accesible: teclado, estado abierto y
                 lectura en voz alta, sin una línea de JavaScript. -->
            <div v-if="entries.length" class="site-faq">
                <details v-for="(entry, index) in entries" :key="index" class="site-faq-item">
                    <summary class="site-faq-question">
                        <span>{{ entry.question }}</span>
                        <IconComponent name="down" :size="12" custom-class="site-faq-chevron" />
                    </summary>
                    <p class="site-faq-answer">{{ entry.answer }}</p>
                </details>
            </div>

        </div>

    </section>

</template>

<script setup>

    import { computed } from 'vue'
    import { IconComponent } from 'innoboxrr-form-elements'
    import { asArray, asObject, asText, filled } from '../../props.js'

    defineOptions({ inheritAttrs: false })

    const props = defineProps(['title', 'subtitle', 'items'])

    const entries = computed(() => asArray(props.items)
        .map(asObject)
        .filter((item) => filled(item.question))
        .map((item) => ({ question: asText(item.question), answer: asText(item.answer) })))

</script>
