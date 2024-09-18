<template>
    <div class="px-8 mx-auto py-8">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3">
            <testkin-card
                v-for="testkin in testkins"
                :key="testkin.id"
                :testkin="testkin"
                :product="testkin.product" 
                :show-full-download="true" />
        </div>
        <div v-if="testkins.length === 0" class="flex justify-center items-center h-[50vh]">
            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-500 dark:text-gray-400">
                    No testkins found
                </h2>
                <p class="text-lg text-gray-400 dark:text-gray-500">
                    There are no testkins available at the moment.
                </p>
            </div>
        </div>
    </div>
</template>

<script>

    import { indexModel as indexTestkinModel } from "@models/testkin";
    import TestkinCard from "@models/testkin/widgets/TestkinCard.vue";

    export default {
        components: {
            TestkinCard
        },
        data() {
            return {
                testkins: [],
            }
        },
        mounted() {
            this.fetchTestkins();
        },
        methods: {
            async fetchTestkins() {
                const testkins = await indexTestkinModel({
                    managed: true,
                    has_product: true,
                    auth_has_benefit: true,
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
                this.testkins = testkins;
            }
        }
    }

</script>