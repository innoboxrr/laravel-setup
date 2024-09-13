<template>
    <div>
        <div class="readable-text read-style" v-html="props.content"></div>
    </div>
</template>
<script>
    export default {
        props: {
            props: {
                type: Object,
                default: () => ({}),
            }
        }
    }
</script>

<style scoped>
    .readable-text {
        padding: 20px; /* Espacio alrededor del texto */
        line-height: 1.6; /* Altura de línea para mejor legibilidad */
        font-size: 18px; /* Tamaño de fuente adecuado para lectura */
        font-family: 'Arial', sans-serif; /* Fuente limpia y fácil de leer */
        color: #333; /* Color de texto con buen contraste */
        border-radius: 8px; /* Bordes redondeados para un aspecto más suave */
        max-width: 800px; /* Limitar el ancho del contenedor para facilitar la lectura */
        margin: 0 auto; /* Centrar el contenido */
    }

    .readable-text p {
        margin-bottom: 16px; /* Espacio entre párrafos */
    }

    @media (max-width: 600px) {
        .readable-text {
            padding: 15px;
            font-size: 16px;
        }
    }
</style>