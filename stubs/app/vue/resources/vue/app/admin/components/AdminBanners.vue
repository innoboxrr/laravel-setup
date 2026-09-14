<template>

    <div v-if="auth.impersonating" class="app-banner" data-variant="warning" role="status">
        <span>
            <IconComponent name="mdi:incognito" :size="16" />
            {{ t('You are viewing the account of :name', { name: userName }) }}
        </span>
        <button type="button" class="fe-button fe-button-sm" :disabled="reverting" @click="revert">
            {{ t('Back to my account') }}
        </button>
    </div>

    <div v-if="auth.authenticated && auth.verified === false" class="app-banner" data-variant="info" role="status">
        <span>
            <IconComponent name="info" :size="16" />
            {{ t('Confirm your email address with the link we sent you.') }}
        </span>
        <button type="button" class="fe-button-secondary fe-button-sm" :disabled="sending" @click="resend">
            {{ sending ? t('Sending…') : t('Resend the email') }}
        </button>
    </div>

</template>

<script setup>

    import { computed, ref } from 'vue'
    import { useRouter } from 'vue-router'
    import t from 'innoboxrr-i18n'
    import { notifyError, notifySuccess } from 'innoboxrr-form-core'
    import { IconComponent } from 'innoboxrr-form-elements'
    import { errorMessage } from '@app/http.js'
    import { useAuthStore } from '@app/stores/auth.js'

    const auth = useAuthStore()
    const router = useRouter()

    const reverting = ref(false)
    const sending = ref(false)

    const userName = computed(() => auth.user?.name ?? auth.user?.email ?? '')

    const revert = async () => {
        reverting.value = true

        try {
            await auth.revertImpersonation()

            // Pasadas dos horas el backend cierra la sesión en vez de devolverla.
            await router.replace(auth.authenticated ? { name: 'admin.dashboard' } : { name: 'auth.login' })
        } catch (error) {
            notifyError(errorMessage(error, t))
        } finally {
            reverting.value = false
        }
    }

    const resend = async () => {
        sending.value = true

        try {
            const data = await auth.resendVerification()

            if (data?.status === 'already-verified') {
                await auth.load()
                notifySuccess(t('Your email address is already confirmed.'))
            } else {
                notifySuccess(t('We sent you a new confirmation link.'))
            }
        } catch (error) {
            notifyError(errorMessage(error, t))
        } finally {
            sending.value = false
        }
    }

</script>
