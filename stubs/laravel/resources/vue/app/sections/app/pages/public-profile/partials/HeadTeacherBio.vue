<template>
    <div v-if="user" class="mb-8">
        <h3 class="text-lg font-bold dark:text-white mb-4">
            My <span class="text-blue-500">bio</span>
        </h3>
        <aside class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
            <div>
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white text-center">
                    {{ user.name }} {{ user.surname }}
                </h2>
                <p class="text-gray-500 dark:text-gray-400 text-center">{{ user.payload.position || 'No position provided' }}</p>
                <!-- Descripción del Quiz -->
                <read-more-component 
                    :text="user.payload.bio_about" 
                    :limit="1000" />
            </div>
            <div class="mt-6">
                <h4 class="text-lg font-medium text-gray-900 dark:text-white">Teacher Stats</h4>
                <ul class="mt-2 space-y-1">
                    <li class="flex justify-between text-gray-700 dark:text-gray-300">
                        <span>Rating:</span>
                        <span class="font-medium">{{ Number(user.payload.teacher_rating ?? 0).toFixed(2) }} / 5</span>
                    </li>
                    <li class="flex justify-between text-gray-700 dark:text-gray-300">
                        <span>Reviews:</span>
                        <span class="font-medium">{{ user.payload.teacher_reviews }}</span>
                    </li>
                    <li class="flex justify-between text-gray-700 dark:text-gray-300">
                        <span>Courses:</span>
                        <span class="font-medium">{{ user.payload.teacher_courses }}</span>
                    </li>
                    <li class="flex justify-between text-gray-700 dark:text-gray-300">
                        <span>Students:</span>
                        <span class="font-medium">{{ user.payload.teacher_students }}</span>
                    </li>
                </ul>
            </div>
            <div class="mt-6">
                <h4 class="text-lg font-medium text-gray-900 dark:text-white">General Information</h4>
                <ul class="mt-2 space-y-1">
                    <li class="flex justify-between text-gray-700 dark:text-gray-300">
                        <span>Email:</span>
                        <span class="font-medium">{{ user.email }}</span>
                    </li>
                    <li class="flex justify-between text-gray-700 dark:text-gray-300">
                        <span>Date of Birth:</span>
                        <span class="font-medium">{{ user.dob }}</span>
                    </li>
                    <li class="flex justify-between text-gray-700 dark:text-gray-300">
                        <span>Timezone:</span>
                        <span class="font-medium">{{ user.payload.timezone }}</span>
                    </li>
                </ul>
            </div>
        </aside>
    </div>
</template>

<script>
export default {
    computed: {
        user() {
            return this.$store.state.adminPublicProfile.user;
        },
    }
}
</script>

<style scoped>
aside {
    max-width: 400px;
    margin: 0 auto;
}
</style>
