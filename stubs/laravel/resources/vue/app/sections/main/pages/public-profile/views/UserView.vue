<template>
    <div>
        <div v-if="user?.payload?.visibility == 'public'">
            <header-section ></header-section>
            <badges-slider></badges-slider>
            <content-grid></content-grid>
        </div>
        <div v-else>
            <div class="flex items-center justify-center h-screen">
                <div class="text-center">
                    <h1 class="text-4xl font-bold text-gray-800 dark:text-white">
                        {{ __('This profile is private') }}
                    </h1>
                    <p class="text-lg text-gray-600 dark:text-gray-400">
                        {{ __('This user has set their profile to private') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { defineAsyncComponent } from 'vue';

    export default {
        components: {
            HeaderSection: defineAsyncComponent(() => import('./../partials/HeaderSection.vue')),
            ContentGrid: defineAsyncComponent(() => import('./../partials/ContentGrid.vue')),
            BadgesSlider: defineAsyncComponent(() => import('./../partials/BadgesSlider.vue'))
        },
        computed: {
            user() {
                return this.$store.state.adminPublicProfile.user;
            }
        }
    }

</script>
