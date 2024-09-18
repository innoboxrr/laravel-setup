<template>
    <div class="divide-y divide-white/5">
        <div class="grid max-w-7xl grid-cols-1 gap-x-8 gap-y-10 px-4 pt-10 pb-16 sm:px-6 md:grid-cols-3 lg:px-8">
            <div>
                <h2 class="text-base font-semibold leading-7 dark:text-white">
                    {{ __('Notifications') }}
                </h2>
                <p class="mt-1 text-sm leading-6 dark:text-gray-400">
                    {{ __('Manage your notifications settings.') }}
                </p>
            </div>
            <div class="md:col-span-2">
                <notifications-settings-form 
                    class="sm:max-w-xl sm:grid-cols-6"
                    :user-id="user.id"
                    @submit="notificationsFormSubmit" />
            </div>
        </div>
    </div>
</template>

<script>
    import NotificationsSettingsForm from '@models/user/forms/NotificationsSettingsForm.vue'
    export default {
        components: {
            NotificationsSettingsForm,
        },
        computed: {
            user() {
                return this.$store.getters['authPages/user']
            }
        },
        methods: {
            async notificationsFormSubmit(data) {
                this.alert('success');
            }
        }
    }
</script>