<template>

    <div class="site">

        <component :is="item.component" v-for="item in parts.before" :key="item.key" v-bind="item.props" />

        <main id="content" class="site-main">
            <component :is="item.component" v-for="item in parts.main" :key="item.key" v-bind="item.props" />
        </main>

        <component :is="item.component" v-for="item in parts.after" :key="item.key" v-bind="item.props" />

    </div>

</template>

<script setup>

    import { computed, onErrorCaptured } from 'vue'
    import defaultRegistry from './sections/index.js'
    import { renderableSections, splitLandmarks } from './render.js'

    const props = defineProps({
        page: { type: Object, default: null },
        registry: { type: Object, default: () => defaultRegistry },
    })

    const parts = computed(() => splitLandmarks(renderableSections(props.page, props.registry)))

    // Unas props escritas a mano pueden romper una sección: esa se queda en
    // blanco y el resto de la página se sigue viendo.
    onErrorCaptured((error, instance) => {
        console.error('[site] A section failed to render.', error, instance?.$options?.name)

        return false
    })

</script>
