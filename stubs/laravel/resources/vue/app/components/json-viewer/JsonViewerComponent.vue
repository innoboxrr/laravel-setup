<template>

<pre 
    v-if="$store.getters['authPages/isAdmin'] && showJsons" 
    class="text-sm text-gray-500 mb-4 bg-gray-900 text-green-400 rounded-lg">{{ JSON.stringify(data, null, 4) }}</pre> 

</template>

<script>

    export default {

        props: {

            data: {

                type: Object,
                required: true

            }

        }

    }

</script>