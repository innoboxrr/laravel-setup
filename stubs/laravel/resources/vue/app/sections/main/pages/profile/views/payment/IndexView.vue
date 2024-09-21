<template>
    <div class="px-8 mx-auto py-8">
        <my-payments-table />
    </div>
</template>
<script>
    import MyPaymentsTable from '@models/payment/widgets/MyPaymentsTable.vue';
    export default {
        components: {
            MyPaymentsTable
        }
    }
</script>