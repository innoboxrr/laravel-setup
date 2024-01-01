<template>
    <div v-if="hasErrors">
        <p v-for="error in errors[type]" :key="error" class="text-red-600 font-bold">{{ error }}</p>
    </div>
</template>

<script>
export default {
    name: 'InputError',
    props: {
        errors: {
            type: [Object, Array],
            required: true
        },
        type: {
            type: String,
            required: true
        }
    },   
    computed: {
        hasErrors() {
            return this.errors && this.errors[this.type] && this.errors[this.type].length > 0;
        }
    }
}
</script>

<style scoped>
    /* Estilos personalizados para los mensajes de error */
    p {
        margin: -20px 0 0 2px;
        font-size: 0.8em;
    }
</style>
