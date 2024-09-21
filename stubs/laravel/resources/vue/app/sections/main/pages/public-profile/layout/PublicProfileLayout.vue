<template>
    <router-view></router-view>
</template>

<script>
    export default {
        mounted() {
            this.$store.dispatch('adminPublicProfile/initModule', {
                userId: this.$route.params.user_id
            })
        }
    }
</script>