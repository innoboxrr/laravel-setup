<template>
    <div class="text-gray-800 dark:text-gray-200 p-4">
        <div class="bg-white p-6 rounded-lg border border-gray-300 dark:bg-slate-800 dark:border-slate-700">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-6">
                <div class="flex items-center">
                    <img :src="user.avatar_url" :alt="`${user.name} ${user.surname}'s avatar`" class="w-24 h-24 rounded-full border-2 border-gray-300">
                    <div class="ml-4">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ user.name }} {{ user.surname }}</h2>
                        <p class="text-gray-600 dark:text-gray-400">{{ user.title }}</p>
                    </div>
                </div>
                <div class="flex flex-col justify-center space-y-2">
                    <div class="flex items-center space-x-2">
                        <span class="text-gray-600 dark:text-gray-400">⭐ {{ rating(user.payload.teacher_rating) || 'N/A' }} Calificación del instructor</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-gray-600 dark:text-gray-400">📜 {{ user.payload.teacher_reviews || 0 }} reseñas</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-gray-600 dark:text-gray-400">👥 {{ user.payload.teacher_students || 0 }} estudiantes</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-gray-600 dark:text-gray-400">📚 {{ user.payload.teacher_courses || 0 }} cursos</span>
                    </div>
                </div>
            </div>
            <div>
                <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-gray-100">
                    {{ __('About the instructor') }}
                </h3>
                <read-more-component 
                    :text="user.payload.bio_about" 
                    :limit="500" />
                <div class="mt-4">
                    <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-gray-100">
                        {{ __('Specialities') }}
                    </h3>
                    <div class="flex flex-wrap gap-2">
                        <span v-for="skill in skillsArray" :key="skill" class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100 rounded-full px-3 py-1 text-sm font-semibold">{{ skill }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        user: {
            type: Object,
            required: true
        }
    },
    computed: {
        skillsArray() {
            if (!this.user.payload.bio_skills || this.user.payload.bio_skills === '') {
                return [];
            }
            return this.user.payload.bio_skills.split(',');
        }
    },
    methods: {
        rating(rating) {
            if (!rating) {
                return null;
            }
            if(!isNaN(rating)) {
                return Number(rating).toFixed(1);
            }
            return rating.toFixed(1);
        }
    }
}
</script>

<style scoped>
.avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    border: 2px solid #ddd;
}
</style>
