<template>
    <modal-component
        v-if="showModal"
        ref="modalRef" 
        id="couponModal"
        :open="modalStatus"
        @close="modalClosed"
        :title="__('Verify your email address')"
        :large-modal="false">
        <template v-slot:body>
            <div class="p-4">
                <div class="text-center">
                    <p class="text-lg dark:text-white">
                        {{ __('Please verify your email address to continue.') }}
                    </p>
                    <p class="text-md mt-4 dark:text-white">
                        {{ __('If you did not receive the email, click the button below to resend.') }}
                    </p>
                    <div class="mt-4">
                        <button
                            @click="resendVerificationEmail"
                            :class="buttonClass">
                            {{ __('Resend Verification Email') }}
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </modal-component>
</template>

<script>    

    import { mapState } from 'vuex';

    export default {
        data() {
            return {
                modalStatus: false,
                modalData: {
                    modalLarge: false,
                },
                showModal: false,
                delay: 10000,
            };
        },
        mounted() {
            if (this.isAuth && !this.isConfirm) {
                this.modalStatus = true;
            }
            setTimeout(() => {
                this.showModal = true;
            }, this.delay);
        },
        computed: {
            ...mapState('authPages', [
                'user',
                'isAuth',
                'isConfirm',
            ]),
        },
        watch: {
            user: {
                handler() {
                    if (this.user && this.user.email_verified_at == null) {
                        this.modalStatus = true;
                    } else {
                        this.modalStatus = false;
                    }
                },
                deep: true,
            },
        },
        methods: {
            modalClosed() {
                location.reload();
            },
            async resendVerificationEmail() {
                await this.$store.dispatch('authPages/emailVerificationNotification');
                this.alert('success', {timer: 4000}, this.__('Verification email sent successfully!'));
            }
        },
    }
</script>