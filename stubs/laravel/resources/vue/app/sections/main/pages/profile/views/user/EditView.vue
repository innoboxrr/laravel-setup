<template>
    <div class="divide-y divide-white/5">
        <!-- Edit account -->
        <div 
            class="grid max-w-7xl grid-cols-1 gap-x-8 gap-y-10 px-4 pt-10 pb-16 sm:px-6 md:grid-cols-3 lg:px-8">
            <div>
                <h2 class="text-base font-semibold leading-7 dark:text-white">
                    {{ __('Personal Information') }}
                </h2>
                <p class="mt-1 text-sm leading-6 dark:text-gray-400">
                    {{ __('Use a permanent address where you can receive mail.') }}
                </p>
            </div>
            <div class="md:col-span-2">
                <edit-form 
                    class="sm:max-w-xl sm:grid-cols-6"
                    :user-id="user.id"
                    @submit="editFormSubmit" />
            </div>
        </div>
        <!-- Change password -->
        <div class="grid max-w-7xl grid-cols-1 gap-x-8 gap-y-10 px-4 py-16 sm:px-6 md:grid-cols-3 lg:px-8">
            <div>
                <h2 class="text-base font-semibold leading-7 dark:text-white">
                    {{ __('Change password') }}
                </h2>
                <p class="mt-1 text-sm leading-6 dark:text-gray-400">
                    {{ __('Update your password associated with your account.') }}
                </p>
            </div>
            <div class="md:col-span-2">
                <change-password-form 
                    class="sm:max-w-xl sm:grid-cols-6"
                    :user-id="user.id"
                    @submit="changePasswordFormSubmit" />
            </div>
        </div>
        <!-- Logout other devices -->
        <div class="grid max-w-7xl grid-cols-1 gap-x-8 gap-y-10 px-4 py-16 sm:px-6 md:grid-cols-3 lg:px-8">
            <div>
                <h2 class="text-base font-semibold leading-7 text-white">
                    {{ __('Log out other sessions') }}
                </h2>
                <p class="mt-1 text-sm leading-6 text-gray-400">
                    {{ __('Please enter your password to confirm you would like to log out of your other sessions across all of your devices.') }}
                </p>
            </div>
            <div class="md:col-span-2">
                <logout-other-devices-form 
                    class="sm:max-w-xl sm:grid-cols-6"
                    :user-id="user.id"
                    @submit="logoutOtherDevicesFormSubmit" />
            </div>
        </div>
        <!-- Delete account -->
        <div class="grid max-w-7xl grid-cols-1 gap-x-8 gap-y-10 px-4 py-16 sm:px-6 md:grid-cols-3 lg:px-8">
            <div>
                <h2 class="text-base font-semibold leading-7 text-white">
                    {{ __('Delete account') }}
                </h2>
                <p class="mt-1 text-sm leading-6 text-gray-400">
                    {{ __('No longer want to use our service? You can delete your account here. This action is not reversible.') }}
                </p>
            </div>
            <div class="md:col-span-2">
                <delete-account-form 
                    class="sm:max-w-xl sm:grid-cols-6"
                    :user-id="user.id"
                    @submit="deleteAccountFormSubmit" />
            </div>
        </div>
    </div>
</template>

<script>

    import EditForm from '@models/user/forms/EditForm.vue'
    import ChangePasswordForm from '@models/user/forms/ChangePasswordForm.vue'
    import LogoutOtherDevicesForm from '@models/user/forms/LogoutOtherDevicesForm.vue'
    import DeleteAccountForm from '@models/user/forms/DeleteAccountForm.vue'

    export default {

        name: 'UserProfileView',

        components: {
            EditForm,
            ChangePasswordForm,
            LogoutOtherDevicesForm,
            DeleteAccountForm
        },

        computed: {
            user() {
                return this.$store.getters['authPages/user']
            }
        },

        methods: {

            editFormSubmit(payload) {
                this.alert('success');
            },

            changePasswordFormSubmit(payload) {
                this.alert('success');
            },

            logoutOtherDevicesFormSubmit(payload) {
                this.alert('success');
            },

            deleteAccountFormSubmit(payload) {
                this.alert('success');
                // Redirect home
                location.href = '/';
            },

        },

    }

</script>