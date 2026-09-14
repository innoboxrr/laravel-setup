<template>

    <section class="site-section">

        <div class="site-container">

            <div v-if="filled(title) || filled(subtitle)" class="site-heading-center">
                <h2 v-if="filled(title)" class="site-title">{{ title }}</h2>
                <p v-if="filled(subtitle)" class="site-lead">{{ subtitle }}</p>
            </div>

            <div v-if="featured || entries.length" class="site-testimonials">

                <figure
                    v-for="(entry, index) in all"
                    :key="index"
                    class="site-card site-testimonial"
                    :class="{ 'site-testimonial-featured': entry.featured }">

                    <blockquote class="site-testimonial-body">
                        <p>“{{ entry.body }}”</p>
                    </blockquote>

                    <figcaption v-if="entry.name || entry.handle" class="site-author">
                        <img v-if="entry.image" :src="entry.image" alt="" class="site-avatar" loading="lazy">
                        <span v-else class="site-avatar" aria-hidden="true">{{ initials(entry.name) }}</span>
                        <span>
                            <span class="site-author-name">{{ entry.name }}</span>
                            <span v-if="entry.handle" class="site-author-handle">{{ entry.handle }}</span>
                        </span>
                    </figcaption>

                </figure>

            </div>

        </div>

    </section>

</template>

<script setup>

    import { computed } from 'vue'
    import { asArray, asObject, asText, filled, imageUrl, initials } from '../../props.js'

    defineOptions({ inheritAttrs: false })

    const props = defineProps(['title', 'subtitle', 'feature', 'items'])

    const normalize = (value, featured = false) => {
        const item = asObject(value)
        const author = asObject(item.author)
        // `message` era el nombre de la clave en las aplicaciones antiguas.
        const body = asText(item.body ?? item.message)

        if (body.trim() === '') {
            return null
        }

        return {
            featured,
            body,
            name: asText(author.name),
            handle: asText(author.handle),
            image: imageUrl(author.image),
        }
    }

    const featured = computed(() => normalize(props.feature, true))

    const entries = computed(() => asArray(props.items).map((item) => normalize(item)).filter(Boolean))

    const all = computed(() => (featured.value ? [featured.value, ...entries.value] : entries.value))

</script>
