<template>
    <div class="container mx-auto p-4 px-0 lg:px-36">
        <div class="flex flex-wrap mx-2">
            <div class="w-full lg:w-8/12 px-2 mb-4">
                <global-stats></global-stats>
                <user-courses></user-courses>
            </div>
            <div class="w-full lg:w-4/12 px-2 mb-4">
                <head-teacher-bio></head-teacher-bio>
                <user-certificates></user-certificates>
            </div>
        </div>
    </div>
</template>
<script>
    import GlobalStats from "./GlobalStats.vue";
    import UserCourses from "./UserCourses.vue";
    import ProfileFeed from "./ProfileFeed.vue";
    import HeadTeacherBio from "./HeadTeacherBio.vue";
    import UserCertificates from "./UserCertificates.vue";

    export default {
        components: {
            GlobalStats,
            UserCourses,
            ProfileFeed,
            HeadTeacherBio,
            UserCertificates
        }
    }

</script>
