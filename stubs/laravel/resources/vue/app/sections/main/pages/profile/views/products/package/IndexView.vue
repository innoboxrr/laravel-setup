<template>
    <div class="mx-8 mx-auto">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3">
            <package-card
                v-for="pack in packages"
                :key="pack.id"
                :package="pack"
                :product="pack.product" />
        </div>
        <div v-if="packages.length === 0" class="flex justify-center items-center h-[50vh]">
            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-500 dark:text-gray-400">
                    No packages found
                </h2>
                <p class="text-lg text-gray-400 dark:text-gray-500">
                    There are no packages available at the moment.
                </p>
            </div>
        </div>
    </div>
</template>

<script>

    import { indexModel as indexPackageModel } from "@models/package";
    import PackageCard from "@models/package/widgets/PackageCard.vue";

    export default {
        components: {
            PackageCard
        },
        data() {
            return {
                packages: [],
            }
        },
        mounted() {
            this.fetchPackages();
        },
        methods: {
            async fetchPackages() {
                const packages = await indexPackageModel({
                    managed: true,
                    has_product: true,
                    auth_has_benefit: true,
                    load_product: true,
                    load_items_productable: true,
                    appends: [
                        'primary_category',
                        'price'
                    ],
                    paginate: 0,
                });
                this.packages = packages;
            }
        }
    }

</script>