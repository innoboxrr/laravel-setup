<template>
    <div class="px-8 mx-auto py-8">
        <my-carts-table />
    </div>
</template>
<script>
    import MyCartsTable from '@models/cart/widgets/MyCartsTable.vue';
    export default {
        components: {
            MyCartsTable
        }
    }
</script>