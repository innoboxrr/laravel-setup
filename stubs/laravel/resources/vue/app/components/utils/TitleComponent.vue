<template>
    <div :class="customClass">
        <h3 class="text-lg font-bold dark:text-white" v-html="title"></h3>
        <p class="text-mobile-small md:text-desktop-small lg:text-desktop-normal mb-0 text-neutral-text dark:text-gray-200" v-html="subtitle"></p>
    </div>
</template>
<script>
    export default {
        name: "TitleComponent",
        props: {
            customClass: {
                type: String,
                default: 'md:mb-6 mx-12',
            },
            title: {
                type: String,
                default: 'Empieza a aprender gratis <span class="text-blue-500">con un click</span>',
            },
            subtitle: {
                type: String,
                default: 'Mira las primeras clases gratis y disfruta la mejor experiencia de aprendizaje',
            }
        },
        data() {
            return {

            }
        },
    }
</script>