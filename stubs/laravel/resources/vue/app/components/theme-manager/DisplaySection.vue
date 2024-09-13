<template>
    <component 
        :is="component" 
        :props="props" />
</template>
<script>
    import { shallowRef, defineAsyncComponent } from 'vue';

    export default {
        props: {
            components: {
                type: Object,
                default: () => ({})
            },
            section: {
                type: Object,
                default: () => ({})
            }
        },
        data() {
            return {
                component: shallowRef(null),
                props: this.section.props || {}
            }
        },
        mounted() {
            this.loadComponent();
        },
        computed: {
            sectionName() {
                if(this.$route.query.oldSection == this.section.name && this.$route.query.newSection != ''){
                    return this.$route.query.newSection;
                } else {
                    return this.section.name;
                }
            }
        },
        methods: {
            async loadComponent() {
                const componentName = `../../themes/${this.section.theme}/${this.section.group}/${this.sectionName}.vue`;

                try {
                    const componentModule = this.components[componentName];
                    if (!componentModule) {
                    throw new Error(`Component not found: ${componentName}`);
                    }

                    const module = await componentModule(); // Wait for the module to load
                    this.component = module.default; // Now access the default export
                } catch (error) {
                    console.error(`Error loading component ${componentName}:`, error);
                    // Handle error, e.g., display a fallback component or an error message
                }
            }
        },
    }
</script>