<template>
    <div class="divide-y divide-white/5">
        <!-- Bio -->
        <div 
            class="grid max-w-7xl grid-cols-1 gap-x-8 gap-y-10 px-4 pt-10 pb-16 sm:px-6 md:grid-cols-3 lg:px-8">
            <div>
                <h2 class="text-base font-semibold leading-7 dark:text-white">
                    {{ __('Bio') }}
                </h2>
                <p class="mt-1 text-sm leading-6 dark:text-gray-400">
                    {{ __('Update your bio') }}
                </p>
            </div>
            <div class="md:col-span-2">
                <bio-form
                    class="sm:max-w-xl sm:grid-cols-6"
                    :user-id="user.id"
                    @submit="bioFormSubmit" />
            </div>
        </div>
        <!-- Edit account -->
        <div 
            class="grid max-w-7xl grid-cols-1 gap-x-8 gap-y-10 px-4 pt-10 pb-16 sm:px-6 md:grid-cols-3 lg:px-8">
            <div>
                <h2 class="text-base font-semibold leading-7 dark:text-white">
                    {{ __('Account Settings') }}
                </h2>
                <p class="mt-1 text-sm leading-6 dark:text-gray-400">
                    {{ __('Update your account settings') }}
                </p>
            </div>
            <div class="md:col-span-2">
                <settings-form
                    class="sm:max-w-xl sm:grid-cols-6"
                    :user-id="user.id"
                    @submit="settingsFormSubmit" />
            </div>
        </div>
    </div>
</template>

<script>

    import { defineAsyncComponent } from 'vue';

    export default {

        name: 'AdvancedSettingsView',

        components: {
            BioForm: defineAsyncComponent(() => import('@models/user/forms/BioForm.vue')),
            SettingsForm: defineAsyncComponent(() => import('@models/user/forms/SettingsForm.vue')),
        },

        computed: {
            user() {
                return this.$store.getters['authPages/user']
            }
        },

        methods: {
            bioFormSubmit(payload) {
                this.alert('success');
            },
            settingsFormSubmit(payload) {
                this.alert('success');
            },
        },

    }

</script>