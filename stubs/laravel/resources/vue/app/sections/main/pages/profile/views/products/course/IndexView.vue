<template>
    <div class="px-8 mx-auto py-8">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3">
            <course-card
                v-for="course in courses"
                :key="course.id"
                :course="course"
                :product="course.product"
                :redirect="{
                    name: 'CourseClassroom',
                    query: { 
                        course_id: course.id 
                    }
                }" />
        </div>
        <div v-if="courses.length === 0" class="flex justify-center items-center h-[50vh]">
            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-500 dark:text-gray-400">
                    No courses found
                </h2>
                <p class="text-lg text-gray-400 dark:text-gray-500">
                    There are no courses available at the moment.
                </p>
            </div>
        </div>
    </div>
</template>

<script>

    import { indexModel as indexCourseModel } from "@models/course";
    import CourseCard from "@models/course/widgets/CourseCard.vue";

    export default {
        components: {
            CourseCard
        },
        data() {
            return {
                courses: [],
            }
        },
        mounted() {
            this.fetchCourses();
        },
        methods: {
            async fetchCourses() {
                const courses = await indexCourseModel({
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
                this.courses = courses;
            }
        }
    }

</script>