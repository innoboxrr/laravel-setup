<template>
    <form @submit.prevent="handleSearch" class="flex mb-4 lg:order-2 lg:mb-0">
        <div class="relative w-full">
            <input
                type="search"
                id="header-search-input"
                class="block w-full rounded-l-md border-0 bg-gray-700 text-gray-300 placeholder:text-gray-400 focus:bg-white focus:text-gray-900 focus:ring-0 focus:placeholder:text-gray-500 sm:text-sm sm:leading-6 py-2"
                :placeholder="__('What are you looking for?')"
                required
                v-model="searchQuery">
        </div>
        <button
            id="header-search-dropdown-button"
            none-data-dropdown-toggle="header-search-dropdown"
            class="hidden md:inline-flex flex-shrink-0 z-10 items-center py-2.5 px-4 text-sm font-medium text-center text-slate-100 border-slate-200 900-l-lg hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-slate-100 bg-blue-500 focus:ring-blue-700 text-white rounded-r-lg"
            type="submit">
            {{ __('Search') }}
        </button>
        <div 
            v-if="false"
            id="header-search-dropdown" 
            class="hidden z-10 w-44 bg-white rounded divide-y divide-slate-100 shadow dark:bg-slate-700" 
            data-popper-reference-hidden="" 
            data-popper-escaped="" 
            data-popper-placement="top" 
            style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate3d(897px, 5637px, 0px);">
            <ul 
                class="py-1 text-sm text-slate-700 dark:text-slate-200" 
                aria-labelledby="header-search-dropdown-button">
                <li>
                    <button 
                        type="button" 
                        class="inline-flex py-2 px-4 w-full hover:bg-slate-100 dark:hover:bg-slate-600 dark:hover:text-white"
                        @click="selectProductType('course')">
                        {{ __('Courses') }}
                    </button>
                </li>
                <li>
                    <button 
                        type="button" 
                        class="inline-flex py-2 px-4 w-full hover:bg-slate-100 dark:hover:bg-slate-600 dark:hover:text-white"
                        @click="selectProductType('testkin')">
                        {{ __('Exams') }}
                    </button>
                </li>
                <li>
                    <button 
                        type="button" 
                        class="inline-flex py-2 px-4 w-full hover:bg-slate-100 dark:hover:bg-slate-600 dark:hover:text-white"
                        @click="selectProductType('voucher')">
                        {{ __('Vouchers') }}
                    </button>
                </li>
                <li>
                    <button 
                        type="button" 
                        class="inline-flex py-2 px-4 w-full hover:bg-slate-100 dark:hover:bg-slate-600 dark:hover:text-white"
                        @click="selectProductType('quiz')">
                        {{ __('Quizzes') }}
                    </button>
                </li>
                <li>
                    <button 
                        type="button" 
                        class="inline-flex py-2 px-4 w-full hover:bg-slate-100 dark:hover:bg-slate-600 dark:hover:text-white"
                        @click="selectProductType('package')">
                        {{ __('Packages') }}
                    </button>
                </li>
            </ul>
        </div>
    </form>
</template>

<script>
export default {
    data() {
        return {
            searchQuery: '',
            productType: 'course',
        };
    },
    computed: {
        productTypeText() {
            return this.replaceWord(this.productType, {
                course: 'Courses',
                testkin: 'Exams',
                voucher: 'Vouchers',
                quiz: 'Quizzes',
                package: 'Packages',
            });
        }
    },
    methods: {
        handleSearch() {
            this.$router.push({ 
                path: '/app/browse/products', 
                query: { q: this.searchQuery, t: this.productType } 
            });
        },
        selectProductType(type) {
            this.productType = type;
            // Trigger the search immediately after selecting the product type if desired
            // this.handleSearch();
        }
    }
};
</script>
