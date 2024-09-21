<template>
    <div class="px-8 mx-auto py-8">
        <div class="grid grid-cols-1 gap-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3">
            <quiz-card
                v-for="quiz in quizzes"
                :key="quiz.id"
                :quiz="quiz"
                :product="quiz.product" 
                :redirect="{
                    name: 'ProfileProductQuizShow',
                    params: {
                        id: quiz.id
                    }
                }" />
        </div>
        <div v-if="quizzes.length === 0" class="flex justify-center items-center h-[50vh]">
            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-500 dark:text-gray-400">
                    No quizzes found
                </h2>
                <p class="text-lg text-gray-400 dark:text-gray-500">
                    There are no quizzes available at the moment.
                </p>
            </div>
        </div>
    </div>
</template>

<script>

    import { indexModel as indexQuizModel } from "@models/quiz";
    import QuizCard from "@models/quiz/widgets/QuizCard.vue";

    export default {
        components: {
            QuizCard
        },
        data() {
            return {
                quizzes: [],
            }
        },
        mounted() {
            this.fetchQuizzes();
        },
        methods: {
            async fetchQuizzes() {
                const quizzes = await indexQuizModel({
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
                this.quizzes = quizzes;
            }
        }
    }

</script>