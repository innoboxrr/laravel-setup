<template>

    <form ref="form" novalidate @submit.prevent="handleSubmit">

        <h1 class="auth-title">{{ t('Forgot your password?') }}</h1>
        <p class="auth-intro">{{ t('Write your email and we will send you a link to choose a new one.') }}</p>

        <p v-if="error" class="app-alert" role="alert">{{ error }}</p>
        <p v-if="sent" class="app-alert" data-variant="success" role="status">{{ sent }}</p>

        <FormField v-model="email" name="email" type="email" :label="t('Email')" autocomplete="email" validators="required email" autofocus />

        <button type="submit" class="fe-button auth-submit" :disabled="busy">
            {{ busy ? t('Sending…') : t('Send the link') }}
        </button>

        <p class="auth-links">
            <RouterLink :to="{ name: 'auth.login' }">{{ t('Back to sign in') }}</RouterLink>
        </p>

    </form>

</template>

<script setup>

    import { ref } from 'vue'
    import { RouterLink } from 'vue-router'
    import t from 'innoboxrr-i18n'
    import FormField from '@app/components/FormField.vue'
    import { useValidatedForm } from '@app/components/useValidatedForm.js'
    import { useAuthStore } from '@app/stores/auth.js'

    const auth = useAuthStore()

    const email = ref('')
    const sent = ref('')

    const { form, busy, error, handleSubmit } = useValidatedForm(async () => {
        sent.value = ''

        // laravel-auth responde lo mismo exista o no la cuenta.
        const data = await auth.forgotPassword({ email: email.value })

        sent.value = data?.message ?? t('If the address is registered, we have emailed you a link.')
    })

</script>
