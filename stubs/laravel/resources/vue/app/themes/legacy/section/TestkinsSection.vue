<template>
    <div v-if="props.display == 'true'" class="m-8 lg:mx-36 mb-12">
        <div class="mx-auto max-w-2xl lg:text-center mb-8 mt-12">
            <h2 class="text-base font-semibold leading-7 text-indigo-600">
                {{ props.pretitle }}
            </h2>
            <p
                class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl"
            >
                {{ props.title }}
            </p>
            <p class="mt-6 text-lg leading-8 text-gray-600">
                {{ props.subtitle }}
            </p>
        </div>

        <div class="sm:hidden pb-4">
            <label for="tabs" class="sr-only">Filter by Category</label>
            <select
                id="tabs"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                @change="categoryId = $event.target.value"
            >
                <option v-for="category in categories" :value="category.id">
                    {{ category.name }}
                </option>
            </select>
        </div>
        <ul
            class="hidden text-sm font-medium text-center text-gray-500 rounded-lg shadow sm:flex dark:divide-gray-700 dark:text-gray-400 mb-8"
        >
            <li
                v-for="category in categories"
                :key="category.id"
                class="w-full focus-within:z-10"
            >
                <a
                    @click="categoryId = category.id"
                    :class="{
                        'inline-block w-full p-4 text-gray-900 bg-gray-100 border-r border-gray-200 dark:border-gray-700 focus:ring-4 focus:ring-blue-300 active focus:outline-none dark:bg-gray-700 dark:text-white':
                            categoryId == category.id,
                        'inline-block w-full p-4 bg-white border-r border-gray-200 dark:border-gray-700 hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700':
                            categoryId != category.id,
                    }"
                    aria-current="page"
                >
                    {{ category.name }}
                </a>
            </li>
        </ul>
        <slider-component
            :key="sliderKey"
            :route="testkinRoute"
            :filters="testkinFilters"
            @isEmpty="showTestkinSlider = false"
        >
            <template v-slot:slider-item="slotProps">
                <testkin-card
                    :show-cart="false"
                    :show-favorite="false"
                    :testkin="slotProps.item"
                    :product="slotProps.item.product"
                />
            </template>
        </slider-component>
        <div v-if="props.banner_display" class="bg-white">
            <div class="px-6 pt-12 sm:px-6">
                <div class="mx-auto max-w-2xl text-center">
                    <h2
                        class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl"
                    >
                        {{ props.banner_title }}
                    </h2>
                    <p
                        class="mx-auto mt-6 max-w-xl text-lg leading-8 text-gray-600"
                    >
                        {{ props.banner_message }}
                    </p>
                    <div class="mt-10 flex items-center justify-center gap-x-6">
                        <a
                            :href="props.banner_button_link"
                            class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 hover:text-white"
                        >
                            {{ props.banner_button_text }}
                            <span aria-hidden="true">→</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import TestkinCard from "@admin/models/testkin/widgets/TestkinCard.vue";
import { indexModel as indexCategoryModel } from "@models/category/index";

export default {
    components: {
        TestkinCard,
    },
    props: {
        props: {
            type: Object,
            default: () => ({}),
        },
    },
    data() {
        return {
            showTestkinSlider: true,
            testkinRoute: route("api.testkin.index"),
            testkinFilters: {
                has_product: true,
                load_product: true,
                load_lessons_count: true,
                load_head_teacher_user: true,
                category_id: this.categoryId,
                status: "published",
                orderBy: "id",
                orderMode: "desc",
                appends: [
                    "primary_category", 
                    "price",
                    "questions_number",
                ],
                paginate: 10,
            },
            categories: [],
            categoryId: null,
            sliderKey: 0,
        };
    },
    async mounted() {
        await this.fetchData();
    },
    watch: {
        categoryId() {
            this.testkinFilters.category_id = this.categoryId;
            this.sliderKey++;
        },
    },
    methods: {
        async fetchData() {
            await this.fetchCategories();
        },
        async fetchCategories() {
            let response = await indexCategoryModel({
                paginate: 0,
                only_parents: true,
                categorizable_type: "App\\Models\\Testkin",
            });
            this.categories = response;
            this.categoryId = this.categories[0].id;
        },
    },
};
</script>
