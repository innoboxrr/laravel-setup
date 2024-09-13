<template>
    <div class="px-8 mx-auto py-8">
        <my-payouts-table />
    </div>
</template>
<script>
    import MyPayoutsTable from '@models/payout/widgets/MyPayoutsTable.vue';
    export default {
        components: {
            MyPayoutsTable
        }
    }
</script>