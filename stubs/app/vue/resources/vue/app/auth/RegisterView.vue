<template>

    <form ref="form" novalidate @submit.prevent="handleSubmit">

        <h1 class="auth-title">{{ t('Create account') }}</h1>
        <p class="auth-intro">{{ t('It only takes a minute.') }}</p>

        <p v-if="error" class="app-alert" role="alert">{{ error }}</p>

        <FormField v-model="name" name="name" :label="t('Name')" autocomplete="name" validators="required" autofocus />

        <FormField v-model="email" name="email" type="email" :label="t('Email')" autocomplete="email" validators="required email" />

        <FormField v-model="password" name="password" type="password" :label="t('Password')" autocomplete="new-password" validators="required" />

        <FormField
            v-model="passwordConfirmation"
            name="password_confirmation"
            type="password"
            :label="t('Confirm password')"
            autocomplete="new-password"
            validators="required password_confirmation" />

        <button type="submit" class="fe-button auth-submit" :disabled="busy">
            {{ busy ? t('Creating account…') : t('Create account') }}
        </button>

        <p class="auth-links">
            <span>{{ t('Already have an account?') }}</span>
            <RouterLink :to="{ name: 'auth.login', query: route.query }">{{ t('Sign in') }}</RouterLink>
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
    import { safeRedirect } from '@app/router/guards.js'
    import { useAuthStore } from '@app/stores/auth.js'

    const route = useRoute()
    const router = useRouter()
    const auth = useAuthStore()

    const name = ref('')
    const email = ref('')
    const password = ref('')
    const passwordConfirmation = ref('')

    const { form, busy, error, handleSubmit } = useValidatedForm(async () => {
        await auth.register({
            name: name.value,
            email: email.value,
            password: password.value,
            password_confirmation: passwordConfirmation.value,
        })

        notifySuccess(t('Your account is ready.'))

        await router.replace(safeRedirect(route.query.redirect) ?? { name: auth.authenticated ? 'admin.dashboard' : 'auth.login' })
    }, {
        // laravel-auth responde 403 cuando `allow-registration` está apagado.
        statusMessages: { 403: t('New accounts are not being accepted right now.') },
    })

</script>
