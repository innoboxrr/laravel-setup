<template>

    <form ref="form" novalidate @submit.prevent="handleSubmit">

        <h1 class="auth-title">{{ t('Sign in') }}</h1>
        <p class="auth-intro">{{ t('Welcome back. Enter your email and your password.') }}</p>

        <p v-if="error" class="app-alert" role="alert">{{ error }}</p>

        <FormField
            v-model="email"
            name="email"
            type="email"
            :label="t('Email')"
            autocomplete="email"
            validators="required email"
            autofocus />

        <FormField
            v-model="password"
            name="password"
            type="password"
            :label="t('Password')"
            autocomplete="current-password"
            validators="required" />

        <div class="auth-row">
            <label class="app-check">
                <input v-model="remember" type="checkbox" name="remember" class="fe-checkbox">
                {{ t('Remember me') }}
            </label>
            <RouterLink :to="{ name: 'auth.forgot-password' }">{{ t('Forgot your password?') }}</RouterLink>
        </div>

        <button type="submit" class="fe-button auth-submit" :disabled="busy">
            {{ busy ? t('Signing in…') : t('Sign in') }}
        </button>

        <p class="auth-links">
            <span>{{ t("Don't have an account?") }}</span>
            <RouterLink :to="{ name: 'auth.register', query: route.query }">{{ t('Create account') }}</RouterLink>
        </p>

    </form>

</template>

<script setup>

    import { ref } from 'vue'
    import { RouterLink, useRoute, useRouter } from 'vue-router'
    import t from 'innoboxrr-i18n'
    import FormField from '@app/components/FormField.vue'
    import { useValidatedForm } from '@app/components/useValidatedForm.js'
    import { safeRedirect } from '@app/router/guards.js'
    import { useAuthStore } from '@app/stores/auth.js'

    const route = useRoute()
    const router = useRouter()
    const auth = useAuthStore()

    const email = ref('')
    const password = ref('')
    const remember = ref(false)

    const { form, busy, error, handleSubmit } = useValidatedForm(async ({ setError }) => {
        await auth.login({ email: email.value, password: password.value, remember: remember.value })

        // El login respondió bien pero la sesión no llegó a get-auth: la cookie
        // no se guarda, casi siempre por SANCTUM_STATEFUL_DOMAINS o SESSION_DOMAIN.
        if (! auth.authenticated) {
            setError(t('You signed in, but the session was not kept. Check the session and Sanctum domains.'))

            return
        }

        await router.replace(safeRedirect(route.query.redirect) ?? { name: 'admin.dashboard' })
    })

</script>
