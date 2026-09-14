<template>

    <RouterLink v-if="internal" :to="href"><slot /></RouterLink>

    <a
        v-else-if="href"
        :href="href"
        :target="newTab ? '_blank' : undefined"
        :rel="newTab ? 'noopener noreferrer' : undefined"><slot /></a>

    <span v-else><slot /></span>

</template>

<script setup>

    import { computed } from 'vue'
    import { RouterLink } from 'vue-router'
    import { isInternalLink, safeHref } from './links.js'

    const props = defineProps({
        to: { default: '' },
        newTab: { type: Boolean, default: false },
    })

    const href = computed(() => safeHref(props.to))

    const internal = computed(() => href.value !== null && isInternalLink(href.value))

</script>
