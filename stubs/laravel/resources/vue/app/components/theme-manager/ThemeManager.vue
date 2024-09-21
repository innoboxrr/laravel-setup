<template>
    <display-section
        v-if="data?.sections && dataLoaded"
        v-for="(section, index) in data.sections"
        :key="index"
        :components="components"
        :section="section" />
</template>
<script>
    import DisplaySection from './DisplaySection.vue';
    export default {
        components: {
            DisplaySection
        },
        props: {
            data: {
                type: Object,
                default: () => ({})
            }
        },
        data() {
            return {
                dataLoaded: false,
                components: {}
            }
        },
        mounted() {
            this.loadComponents();
        },
        methods: {
            async loadComponents() {
                const components = await import.meta.glob('../../themes/**/*.vue');
                this.components = components;
                this.dataLoaded = true;
            }
        },
    }
</script>