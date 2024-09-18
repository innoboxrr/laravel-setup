<template>
    <div class="px-8 mx-auto py-8">
        <div v-if="quiz && user">
            <quiz-quizzable 
                :quiz-id="quiz.id"
                quizzable-type="user"
                :quizzable-id="user.id" />
        </div>
        <div v-else>
            <div class="flex justify-center items-center h-[50vh]">
                <div class="text-center">
                    <h2 class="text-2xl font-bold text-gray-500 dark:text-gray-400">
                        No quiz found
                    </h2>
                    <p class="text-lg text-gray-400 dark:text-gray-500">
                        The quiz you are looking for does not exist.
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import { defineAsyncComponent } from 'vue';
    import { showModel as showQuizModel } from "@models/quiz";
    export default {
        name: 'QuizShowView',
        components: {
            QuizQuizzable: defineAsyncComponent(() => import("@models/quizzable/widgets/QuizQuizzable.vue")),
        },
        data() {
            return {
                quiz: null,
            }
        },
        mounted() {
            this.fetchQuiz();
        },
        computed: {
            user() {
                return this.$store.state.authPages.user;
            }
        },
        methods: {
            async fetchQuiz() {
                if (!this.$route.params.id) {
                    return;
                }
                const quiz = await showQuizModel(this.$route.params.id);
                this.quiz = quiz;
            }
        }
    }
</script>