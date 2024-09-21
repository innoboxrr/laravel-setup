<template>
    <div class="px-8 mx-auto py-8">
        <my-benefits-table />
    </div>
</template>
<script>
    import MyBenefitsTable from '@models/benefit/widgets/MyBenefitsTable.vue';
    export default {
        components: {
            MyBenefitsTable
        }
    }
</script>