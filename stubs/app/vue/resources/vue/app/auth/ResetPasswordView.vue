<template>

    <form ref="form" novalidate @submit.prevent="handleSubmit">

        <h1 class="auth-title">{{ t('Choose a new password') }}</h1>
        <p class="auth-intro">{{ t('Write it twice to make sure it is right.') }}</p>

        <p v-if="error" class="app-alert" role="alert">{{ error }}</p>

        <FormField v-model="email" name="email" type="email" :label="t('Email')" autocomplete="email" readonly />

        <FormField v-model="password" name="password" type="password" :label="t('New password')" autocomplete="new-password" validators="required" autofocus />

        <FormField
            v-model="passwordConfirmation"
            name="password_confirmation"
            type="password"
            :label="t('Confirm password')"
            autocomplete="new-password"
            validators="required password_confirmation" />

        <button type="submit" class="fe-button auth-submit" :disabled="busy">
            {{ busy ? t('Saving…') : t('Save the new password') }}
        </button>

        <p class="auth-links">
            <RouterLink :to="{ name: 'auth.forgot-password' }">{{ t('Request another link') }}</RouterLink>
        </p>

    </form>

</template>

<script setup>

    import { ref } from 'vue'
    import { RouterLink, useRoute, useRouter } from 'vue-router'
    import t from 'innoboxrr-i18n'
    import { notifySuccess } from 'innoboxrr-form-core'
    import FormField from '@app/components/FormField.vue'
    import { useValidatedForm } from '@app/components/useValidatedForm.js'
    import { useAuthStore } from '@app/stores/auth.js'

    const route = useRoute()
    const router = useRouter()
    const auth = useAuthStore()

    // El correo llega codificado en la URL; vue-router ya lo entrega decodificado.
    const email = ref(String(route.params.email ?? ''))
    const password = ref('')
    const passwordConfirmation = ref('')

    const { form, busy, error, handleSubmit } = useValidatedForm(async () => {
        const data = await auth.resetPassword({
            token: String(route.params.token ?? ''),
            email: email.value,
            password: password.value,
            password_confirmation: passwordConfirmation.value,
        })

        notifySuccess(data?.message ?? t('Your password has been reset.'))

        await router.replace({ name: 'auth.login' })
    })

</script>
