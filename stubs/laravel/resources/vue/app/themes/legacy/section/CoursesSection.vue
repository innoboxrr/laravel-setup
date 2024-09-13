<template>
    <div
        v-if="props.display == 'true'"
        id="course_section"
        class="m-8 lg:mx-36 mb-12"
    >
        <div class="mx-auto max-w-2xl lg:text-center my-16">
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
        <slider-component
            :route="courseRoute"
            :filters="courseFilters"
            @isEmpty="showCourseSlider = false"
        >
            <template v-slot:slider-item="slotProps">
                <course-card
                    :show-cart="false"
                    :show-favorite="false"
                    :course="slotProps.item"
                    :product="slotProps.item.product"
                />
            </template>
        </slider-component>
        <!--
        <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 mt-4">
            <article 
                v-for="course in courses"
                :key="course.id"
                class="flex flex-col relative rounded-lg shadow bg-white dark:bg-neutral-800">
                <div class="relative w-full min-h-[12rem] pt-[56.25%] overflow-hidden rounded-t-md">
                    <router-link 
                        :to="{ path: 'app/course/1/show' }">
                        <img 
                            class="absolute top-0 w-full h-full object-contain" 
                            src="https://images.unsplash.com/photo-1649180556628-9ba704115795?w=640&h=480&crop=entropy" 
                            loading="lazy" 
                            alt="">
                    </router-link>
                    <div class="flex flex-col justify-between w-full h-full absolute top-0 p-3">
                        <div class="flex gap-3 justify-between items-start">
                            <label class="ms-auto rounded-full cursor-pointer" aria-label="Bookmark">
                                <input type="checkbox" class="peer sr-only" checked>
                                <span class="group inline-flex justify-center items-center w-8 h-8 rounded-full bg-white">
                                    <i class="iconify icon-[heroicons--bookmark-solid] w-4 h-4 text-neutral-500 peer-checked:group-[]:text-red-600"></i>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col h-full px-3 pb-3">
                    <div class="flex gap-1 flex-wrap mt-3">
                        <span class="inline-flex gap-1 items-center text-xs overflow-hidden px-2 py-1 rounded bg-green-200 text-neutral-900">
                            <i class="iconify icon-[solar--crown-star-bold] w-4 h-4 shrink-0"></i>
                            <span class="truncate">Editors' Choice</span>
                        </span>
                    </div>
                    <h4 class="text-lg font-bold leading-6 mt-2">
                        <a href="/app/course/1/show">The Complete Python Programming Course</a>
                    </h4>
                    <div class="flex gap-1 items-center mt-1">
                        <span class="text-sm font-bold text-amber-500">4.7</span>
                        <span class="inline-flex text-amber-500">
                            <i class="iconify icon-[material-symbols--star] w-4 h-4"></i>
                            <i class="iconify icon-[material-symbols--star] w-4 h-4"></i>
                            <i class="iconify icon-[material-symbols--star] w-4 h-4"></i>
                            <i class="iconify icon-[material-symbols--star] w-4 h-4"></i>
                            <i class="iconify icon-[material-symbols--star-half] w-4 h-4"></i>
                        </span>
                        <span class="text-xs font-semibold line-clamp-1 text-neutral-500 dark:text-neutral-400">
                            (67)
                        </span>
                    </div>
                    <div class="flex gap-1 flex-wrap text-xs mt-2 [&>*]:before:content-['_•_'] [&>:first-child]:before:content-none text-neutral-500 dark:text-neutral-400">
                        <span>50 Lessons</span>
                        <span>90h 45m</span>
                        <span>All Levels</span>
                        <span>325 Students</span>
                    </div>
                    <div class="flex gap-3 justify-between items-center mt-auto pt-4">
                        <div class="text-start">
                            <div class="flex gap-2 items-center text-sm">
                                <img 
                                    class="h-7 w-7" 
                                    src="https://cdn.svgporn.com/logos/python.svg" 
                                    loading="lazy" 
                                    alt="">
                                <a href="/app/course/1/show" class="line-clamp-1">
                                    Python Software Foundation
                                </a>
                                <i class="iconify icon-[heroicons--check-badge-solid] w-5 h-5 shrink-0 text-green-500"></i>
                            </div>
                        </div>
                        <div class="text-end shrink-0">
                            <div class="flex gap-2 items-center">
                                <div class="text-lg font-extrabold text-green-600">
                                    FREE
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    -->
        <div v-if="props.banner_display == 'true'" class="bg-white">
            <div class="px-6 pt-6 sm:px-6">
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
import CourseCard from "@admin/models/course/widgets/CourseCard.vue";

export default {
    components: {
        CourseCard,
    },
    props: {
        props: {
            type: Object,
            default: () => ({}),
        },
    },
    data() {
        return {
            showCourseSlider: true,
            courseRoute: route("api.course.index"),
            courseFilters: {
                has_product: true,
                load_product: true,
                load_lessons_count: true,
                load_head_teacher_user: true,
                status: "published",
                orderBy: "id",
                orderMode: "desc",
                appends: [
                    "primary_category", 
                    "price"
                ],
                paginate: 10,
            },
        };
    },
};
</script>
