<template>
    <div class="px-8 mx-auto py-8">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3">
            <voucher-card
                v-for="voucher in vouchers"
                :key="voucher.id"
                :voucher="voucher"
                :product="voucher.product"
                :load-voucher-sent="true" />
        </div>
        <div v-if="vouchers.length === 0" class="flex justify-center items-center h-[50vh]">
            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-500 dark:text-gray-400">
                    No vouchers found
                </h2>
                <p class="text-lg text-gray-400 dark:text-gray-500">
                    There are no vouchers available at the moment.
                </p>
            </div>
        </div>
    </div>
</template>

<script>

    import { indexModel as indexVoucherModel } from "@models/voucher";
    import VoucherCard from "@models/voucher/widgets/VoucherCard.vue";

    export default {
        components: {
            VoucherCard
        },
        data() {
            return {
                vouchers: [],
            }
        },
        mounted() {
            this.fetchVouchers();
        },
        methods: {
            async fetchVouchers() {
                const vouchers = await indexVoucherModel({
                    managed: true,
                    has_product: true,
                    auth_has_benefit: true,
                    load_product: true,
                    load_lessons_count: true,
                    load_head_teacher_user: true,
                    appends: [
                        'primary_category',
                        'price'
                    ],
                    paginate: 0,
                });
                this.vouchers = vouchers;
            }
        }
    }
</script>