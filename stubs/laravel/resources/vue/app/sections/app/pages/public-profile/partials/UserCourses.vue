<template>
    <div>
        <div v-if="headTeacherEnrollments.length > 0" class="mx-auto mt-8 w-full max-w-2xl">
            <h3 class="text-lg font-bold dark:text-white my-4">
                {{ __('Courses as') }} <span class="text-blue-500">{{ __('Head Teacher') }}</span>
            </h3>
            <template 
                v-for="enrollment in headTeacherEnrollments" 
                :key="enrollment.id">
                <div
                    v-if="enrollment.course && enrollment.course.id" 
                    class="card p-2.5 bg-slate-100 dark:bg-slate-800 rounded-lg mb-2">
                    <div class="flex justify-between space-x-2">
                        <div class="flex flex-1 flex-col justify-between">
                            <div>
                                <router-link 
                                    :to="{
                                        name: 'CoursePage',
                                        params: {
                                            course_id: enrollment?.course?.id,
                                            course_slug: slugify(enrollment?.course?.name)
                                        }
                                    }"
                                    class="font-medium text-slate-700 outline-none transition-colors line-clamp-2 hover:text-primary focus:text-primary dark:text-navy-100 dark:hover:text-accent-light dark:focus:text-accent-light">
                                    {{ enrollment.course.name }}
                                </router-link>  
                                <router-link 
                                    :to="{
                                        name: 'CoursePage',
                                        params: {
                                            course_id: enrollment.course.id,
                                            course_slug: slugify(enrollment.course.name)
                                        }
                                    }"
                                    class="text-xs text-slate-400 hover:text-slate-800 dark:text-navy-300 dark:hover:text-navy-100">
                                    {{ strlimit(enrollment.course.short_description, 150) }}
                                </router-link>  
                            </div>

                            <!-- Nueva sección con fondo diferente para tiempo, reseñas y botón de "Ver" -->
                            <div class="flex justify-between items-center mt-auto pt-4 p-1 rounded-lg">
                                <div class="flex items-center text-xs text-neutral-600 dark:text-neutral-300">
                                    <span class="font-bold text-amber-500 mr-1">
                                        {{ enrollment.course.product.ratings_average }}
                                    </span>
                                    <div v-html="starsComponent(enrollment.course.product.ratings_average)"></div>
                                    <span v-if="raitingCount" class="ml-1">
                                        ({{ raitingCount }})
                                    </span>
                                    <span class="mx-2">•</span>
                                    <span v-if="enrollment.course.product.ratings_count">
                                        {{ enrollment.course.product.ratings_count }} {{ __("Reviews") }}
                                    </span>
                                    <span class="mx-2">•</span>
                                    <span>{{
                                        formatSeconds(enrollment.course.duration, "h. ", "m. ", "s. ", false)
                                    }}</span>
                                </div>
                                <div>
                                    <router-link
                                        :to="{
                                            name: 'CoursePage',
                                            params: {
                                                course_id: enrollment.course.id,
                                                course_slug: slugify(enrollment.course.name)
                                            }
                                        }"
                                        class="inline-flex items-center justify-center w-[6rem] text-sm px-3 py-2 rounded-full bg-neutral-900 dark:bg-white hover:bg-neutral-700 dark:hover:bg-neutral-200 text-white dark:text-neutral-900">
                                        <span class="truncate">View</span>
                                    </router-link>
                                </div>
                            </div>
                        </div>
                        <img 
                            class="size-24 rounded-lg object-cover" 
                            :src="enrollment.course.feature_image" 
                            alt="image">
                    </div>
                </div>

            </template>
        </div>

        <div v-if="coursesInProgress.length > 0 && headTeacherEnrollments == 0" class="mx-auto mt-8 w-full max-w-2xl">
            <h3 class="text-lg font-bold dark:text-white my-4">
                {{ __('Course in') }} <span class="text-blue-500">{{ __('progress') }}</span>
            </h3>
            <template 
                v-for="enrollment in coursesInProgress" 
                :key="enrollment.id">
                <div
                v-if="enrollment.course && enrollment.course.id" 
                    class="card p-2.5 bg-slate-100 dark:bg-slate-800 rounded-lg mb-2">
                    <div class="flex justify-between space-x-2">
                        <div class="flex flex-1 flex-col justify-between">
                            <div>
                                <router-link 
                                    :to="{
                                        name: 'CoursePage',
                                        params: {
                                            course_id: enrollment?.course?.id,
                                            course_slug: slugify(enrollment?.course?.name)
                                        }
                                    }"
                                    class="font-medium text-slate-700 outline-none transition-colors line-clamp-2 hover:text-primary focus:text-primary dark:text-navy-100 dark:hover:text-accent-light dark:focus:text-accent-light">
                                    {{ enrollment.course.name }}
                                </router-link>  
                                <router-link 
                                    :to="{
                                        name: 'CoursePage',
                                        params: {
                                            course_id: enrollment.course.id,
                                            course_slug: slugify(enrollment.course.name)
                                        }
                                    }"
                                    class="text-xs text-slate-400 hover:text-slate-800 dark:text-navy-300 dark:hover:text-navy-100">
                                    {{ strlimit(enrollment.course.short_description, 150) }}
                                </router-link>  
                            </div>
                            <div class="flex items-center space-x-2 text-xs py-4">
                                <div class="flex shrink-0 items-center space-x-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5 text-slate-400 dark:text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="dark:text-gray-100">
                                        {{ (enrollment.dedication / 3600).toFixed(0) }}h {{ __('dedication') }}
                                    </p>
                                </div>
                                <div class="mx-2 my-1 w-px self-stretch bg-slate-200 dark:bg-navy-500"></div>
                                <span class="line-clamp-1 dark:text-gray-100">
                                    {{ enrollment.progress }}% {{ __('completed') }}
                                </span>
                            </div>
                        </div>
                        <img 
                            class="size-24 rounded-lg object-cover" 
                            :src="enrollment.course.feature_image" 
                            alt="image">
                    </div>
                </div>
            </template>
        </div>

        <div v-if="completedCourses.length > 0 && headTeacherEnrollments == 0" class="mx-auto mt-8 w-full max-w-2xl">
            <h3 class="text-lg font-bold dark:text-white mt-4 mb-4">
                {{ __('Completed') }} <span class="text-blue-500">{{ __('courses') }}</span>
            </h3>
            <div 
                v-for="enrollment in completedCourses" 
                :key="enrollment.id">
                <div
                    v-if="enrollment.course && enrollment.course.id" 
                    class="card p-2.5 bg-slate-100 dark:bg-slate-800 rounded-lg mb-2">
                    <div class="flex justify-between space-x-2">
                        <div class="flex flex-1 flex-col justify-between">
                            <div>
                                <router-link 
                                    :to="{
                                        name: 'CoursePage',
                                        params: {
                                            course_id: enrollment.course.id,
                                            course_slug: slugify(enrollment.course.name)
                                        }
                                    }"
                                    class="font-medium text-slate-700 outline-none transition-colors line-clamp-2 hover:text-primary focus:text-primary dark:text-navy-100 dark:hover:text-accent-light dark:focus:text-accent-light">
                                    {{ enrollment.course.name }}
                                </router-link>  
                                <router-link 
                                    :to="{
                                        name: 'CoursePage',
                                        params: {
                                            course_id: enrollment.course.id,
                                            course_slug: slugify(enrollment.course.name)
                                        }
                                    }"
                                    class="text-xs text-slate-400 hover:text-slate-800 dark:text-navy-300 dark:hover:text-navy-100">
                                    {{ strlimit(enrollment.course.short_description, 150) }}
                                </router-link>  
                            </div>
                            <div class="flex items-center space-x-2 text-xs py-4">
                                <div class="flex shrink-0 items-center space-x-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5 text-slate-400 dark:text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="dark:text-gray-100">
                                        {{ (enrollment.dedication / 60).toFixed(0) }}h {{ __('dedication') }}
                                    </p>
                                </div>
                                <div class="mx-2 my-1 w-px self-stretch bg-slate-200 dark:bg-navy-500"></div>
                                <span class="line-clamp-1 dark:text-gray-100">
                                    {{ enrollment.progress }}% {{ __('completed') }}
                                </span>
                            </div>
                        </div>
                        <img 
                            class="size-24 rounded-lg object-cover" 
                            :src="enrollment.course.feature_image" 
                            alt="image">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import { starsComponent } from "@app/components/stars";
    export default {
        computed: {
            coursesInProgress() {
                return this.$store.state.adminPublicProfile.user?.in_progress_enrollments || [];
            },
            completedCourses() {
                return this.$store.state.adminPublicProfile.user?.completed_enrollments || [];
            },
            headTeacherEnrollments() {
                return this.$store.state.adminPublicProfile.user?.head_teacher_enrollments || [];
            },
        },
        methods: {
            starsComponent(rating) {
                return starsComponent(rating);
            },
        },
    }
</script>
