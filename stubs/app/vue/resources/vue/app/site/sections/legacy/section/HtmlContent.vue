<template>

    <section class="site-section">

        <div class="site-container site-narrow">

            <!-- HTML que escribe el administrador desde el editor del sitio: es
                 contenido de confianza, igual que en el theme-manager de antes. -->
            <div class="site-prose" v-html="html" />

        </div>

    </section>

</template>

<script setup>

    import { computed } from 'vue'
    import { asText } from '../../props.js'

    defineOptions({ inheritAttrs: false })

    const props = defineProps(['content'])

    const html = computed(() => asText(props.content))

</script>
