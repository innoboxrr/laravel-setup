<template>
    <div class="order-first col-span-12 grid grid-cols-1 gap-2 sm:grid-cols-2 sm:gap-5 lg:order-none lg:col-span-2 lg:gap-2">
        <!-- Course in porgress -->
        <div
            v-if="!isHeadTeacher" 
            class="card justify-between p-5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 rounded-lg">
            <p class="font-small text-sm dark:text-white">
                {{ __('Courses in progress') }}
            </p>
            <div class="flex items-center justify-between pt-4">
                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                    {{ stats.coursesInProgress }}
                </p>
                <svg xmlns="http://www.w3.org/2000/svg" class="size-10 text-primary dark:text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>
        <!-- Completed courses -->
        <div
            v-if="!isHeadTeacher"  
            class="card justify-between p-5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 rounded-lg">
            <p class="font-small text-sm dark:text-white">
                {{ __('Completed courses') }}
            </p>
            <div class="flex items-center justify-between pt-4">
                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                    {{ stats.completedCourses }}
                </p>
                <svg xmlns="http://www.w3.org/2000/svg" class="size-10 text-secondary dark:text-secondary-light" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                </svg>
            </div>
        </div>
        <!-- Watching time -->
        <div
            v-if="!isHeadTeacher"  
            class="card justify-between p-5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 rounded-lg">
            <p class="font-small text-sm dark:text-white">
                {{ __('Watching time') }}
            </p>
            <div class="flex items-center justify-between pt-4">
                <p class="text-slate-700 dark:text-navy-100">
                    <span class="text-xl font-semibold">
                        {{ stats.dedicationTime }}
                    </span>
                    <span class="text-xs ml-1">hrs.</span>
                </p>
                <svg xmlns="http://www.w3.org/2000/svg" class="size-10 text-warning" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>
        
        <!-- teacherRating -->
        <div
            v-if="isHeadTeacher"  
            class="card justify-between p-5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 rounded-lg">
            <p class="font-small text-sm dark:text-white">
                {{ __('Teacher rating') }}
            </p>
            <div class="flex items-center justify-between pt-4">
                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                    {{ Number(stats.teacherRating ?? 0).toFixed(1) }}
                </p>
                <svg xmlns="http://www.w3.org/2000/svg" class="size-10 text-warning" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 .587l3.668 7.568L24 9.753l-6 6.026 1.447 8.717L12 19.84l-7.447 4.656L6 15.779l-6-6.026 8.332-1.598z"/>
                </svg>
            </div>  
        </div>  

        <!-- teacherReviews -->
        <div
            v-if="isHeadTeacher"  
            class="card justify-between p-5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 rounded-lg">
            <p class="font-small text-sm dark:text-white">
                {{ __('Teacher reviews') }}
            </p>
            <div class="flex items-center justify-between pt-4">
                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                    {{ stats.teacherReviews }}
                </p>
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" class="size-10 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M3.559 4.544c.355-.35.834-.544 1.33-.544H19.11c.496 0 .975.194 1.33.544.356.35.559.829.559 1.331v9.25c0 .502-.203.981-.559 1.331-.355.35-.834.544-1.33.544H15.5l-2.7 3.6a1 1 0 0 1-1.6 0L8.5 17H4.889c-.496 0-.975-.194-1.33-.544A1.868 1.868 0 0 1 3 15.125v-9.25c0-.502.203-.981.559-1.331ZM7.556 7.5a1 1 0 1 0 0 2h8a1 1 0 0 0 0-2h-8Zm0 3.5a1 1 0 1 0 0 2H12a1 1 0 1 0 0-2H7.556Z" clip-rule="evenodd"/>
                </svg>
            </div>
        </div>

        <!-- teacherStudents -->
        <div
            v-if="isHeadTeacher"  
            class="card justify-between p-5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 rounded-lg">
            <p class="font-small text-sm dark:text-white">
                {{ __('Teacher students') }}
            </p>
            <div class="flex items-center justify-between pt-4">
                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                    {{ stats.teacherStudents }}
                </p>
                <svg xmlns="http://www.w3.org/2000/svg" class="size-10 text-indigo-700" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-3.31 0-6 2.69-6 6v1h12v-1c0-3.31-2.69-6-6-6z"/>
                </svg>

            </div>
        </div>

        <!-- Certificates -->
        <div class="card justify-between p-5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 rounded-lg">
            <p class="font-small text-sm dark:text-white">
                {{ __('Participations') }}
            </p>
            <div class="flex items-center justify-between pt-4">
                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                    {{ stats.commentsCount }}
                </p>
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg"class="size-10 text-info" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path fill-rule="evenodd" d="M3.559 4.544c.355-.35.834-.544 1.33-.544H19.11c.496 0 .975.194 1.33.544.356.35.559.829.559 1.331v9.25c0 .502-.203.981-.559 1.331-.355.35-.834.544-1.33.544H15.5l-2.7 3.6a1 1 0 0 1-1.6 0L8.5 17H4.889c-.496 0-.975-.194-1.33-.544A1.868 1.868 0 0 1 3 15.125v-9.25c0-.502.203-.981.559-1.331ZM7.556 7.5a1 1 0 1 0 0 2h8a1 1 0 0 0 0-2h-8Zm0 3.5a1 1 0 1 0 0 2H12a1 1 0 1 0 0-2H7.556Z" clip-rule="evenodd"/>
                </svg>
            </div>
        </div>

    </div>
</template>
<script>
    export default {
        computed: {
            stats() {
                return this.$store.state.adminPublicProfile.stats
            },
            isHeadTeacher() {
                return this.$store.state.adminPublicProfile.isHeadTeacher
            }
        }
    }
</script>
