<template>
    <div
        v-if="props.display == 'true'" 
        class="m-8 lg:mx-36 mb-24">
        <div class="mx-auto max-w-2xl lg:text-center my-16">
            <h2 class="text-base font-semibold leading-7 text-indigo-600">
                {{ props.pretitle }}
            </h2>
            <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                {{ props.title }}
            </p>
            <p class="mt-6 text-lg leading-8 text-gray-600">
                {{ props.subtitle }}
            </p>
        </div>
        

        <div v-flowbite id="controls-carousel" class="relative w-full dark" data-carousel="static">
            <!-- Carousel wrapper -->
            <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                <!-- Item 1 -->
                <div 
                    class="hidden duration-700 ease-in-out" 
                    data-carousel-item>
                    <div class="grid grid-cols-2 sm:grid-cols-5 gap-2">
                        <img 
                            class="w-full size-20 object-cover" 
                            src="https://images.unsplash.com/photo-1540575861501-7cf05a4b125a?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=560&q=80" 
                            alt="Gallery Image">
                    </div>
                </div>
            </div>
            <!-- Slider controls -->
            <button type="button" class="absolute top-0 start-0 md:-start-15 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                    </svg>
                    <span class="sr-only">Previous</span>
                </span>
            </button>
            <button type="button" class="absolute top-0 end-0 md:-end-15 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="sr-only">Next</span>
                </span>
            </button>
        </div>

        <div
            v-if="props.banner_display"  
            class="bg-white">
            <div class="px-6 pt-24 sm:px-6">
                <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                    {{ props.banner_title }}
                </h2>
                <p class="mx-auto mt-6 max-w-xl text-lg leading-8 text-gray-600">
                    {{ props.banner_message }}
                </p>
                <div class="mt-10 flex items-center justify-center gap-x-6">
                    <a 
                        :href="props.banner_button_link"
                        class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 hover:text-white">
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

    export default {
        components: {
            TestkinCard,
        },
        props: {
            props: {
                type: Object,
                default: () => ({}),
            }
        },
        data() {
            return {
                testkins: [],
                showTestkinSlider: true,
                testkinRoute: route('api.testkin.index'),
                testkinFilters: {
                    has_product: true,
                    load_product: true,
                    load_lessons_count: true,
                    load_head_teacher_user: true,
                    status: 'published',
                    orderBy: 'id',
                    orderMode: 'desc',
                    appends: [
                        'primary_category',
                        'price'
                    ],
                    paginate: 10,
                },
            }
        },
        mounted() {
            this.fetchTestkins();
        },
        methods: {
            fetchTestkins() {
                this.$refs.testkinCard.fetchTestkins();
            }
        }
    }
</script>