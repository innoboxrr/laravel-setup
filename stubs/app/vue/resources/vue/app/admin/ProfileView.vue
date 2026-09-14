<template>

    <div class="app-page app-page-narrow">

        <header class="app-page-header">
            <div>
                <h1 class="app-page-title">{{ t('Profile') }}</h1>
                <p class="app-page-intro">{{ t('Your name, your email, your photo and your password.') }}</p>
            </div>
        </header>

        <section class="fe-surface app-card" aria-labelledby="profile-avatar">
            <h2 id="profile-avatar" class="app-card-title">{{ t('Photo') }}</h2>

            <div class="app-avatar-row">
                <img v-if="avatar" :src="avatar" alt="" class="app-avatar app-avatar-lg">
                <span v-else class="app-avatar app-avatar-lg" aria-hidden="true">{{ initials }}</span>

                <div class="app-avatar-actions">
                    <input
                        :id="fileId"
                        ref="fileInput"
                        type="file"
                        accept="image/*"
                        class="visually-hidden"
                        :disabled="uploading"
                        @change="onAvatarChange">
                    <label :for="fileId" class="fe-button-secondary fe-button-sm" :aria-disabled="uploading ? 'true' : undefined">
                        {{ uploading ? t('Uploading…') : t('Choose a photo') }}
                    </label>
                    <button v-if="avatar" type="button" class="fe-button-link fe-text-sm" :disabled="uploading" @click="removeAvatar">
                        {{ t('Remove photo') }}
                    </button>
                </div>
            </div>

            <p v-if="avatarError" class="app-alert app-card-alert" role="alert">{{ avatarError }}</p>
        </section>

        <section class="fe-surface app-card" aria-labelledby="profile-account">
            <h2 id="profile-account" class="app-card-title">{{ t('Account') }}</h2>

            <form ref="accountForm" novalidate @submit.prevent="saveAccount">
                <p v-if="accountError" class="app-alert" role="alert">{{ accountError }}</p>

                <FormField v-model="name" name="name" :label="t('Name')" autocomplete="name" validators="required" />
                <FormField v-model="email" name="email" type="email" :label="t('Email')" autocomplete="email" validators="required email" />

                <div class="app-form-actions">
                    <button type="submit" class="fe-button" :disabled="accountBusy">
                        {{ accountBusy ? t('Saving…') : t('Save') }}
                    </button>
                </div>
            </form>
        </section>

        <section class="fe-surface app-card" aria-labelledby="profile-password">
            <h2 id="profile-password" class="app-card-title">{{ t('Password') }}</h2>

            <form ref="passwordForm" novalidate @submit.prevent="savePassword">
                <p v-if="passwordError" class="app-alert" role="alert">{{ passwordError }}</p>

                <FormField v-model="oldPassword" name="old_password" type="password" :label="t('Current password')" autocomplete="current-password" validators="required" />
                <FormField v-model="newPassword" name="password" type="password" :label="t('New password')" autocomplete="new-password" validators="required" />
                <FormField
                    v-model="passwordConfirmation"
                    name="password_confirmation"
                    type="password"
                    :label="t('Confirm password')"
                    autocomplete="new-password"
                    validators="required password_confirmation" />

                <div class="app-form-actions">
                    <button type="submit" class="fe-button" :disabled="passwordBusy">
                        {{ passwordBusy ? t('Saving…') : t('Change password') }}
                    </button>
                </div>
            </form>
        </section>

    </div>

</template>

<script setup>

    import { computed, ref, useId, watch } from 'vue'
    import t from 'innoboxrr-i18n'
    import { notifySuccess } from 'innoboxrr-form-core'
    import FormField from '@app/components/FormField.vue'
    import { useValidatedForm } from '@app/components/useValidatedForm.js'
    import { apiUrl, errorMessage, http, validationErrors } from '@app/http.js'
    import { useAuthStore } from '@app/stores/auth.js'
    import { avatarOf, initialsOf } from './user.js'

    /**
     * El usuario lo genera LaraPack (laraimport.json): su update es
     * `api.app.user.update` y guarda `avatar` como meta con el mismo update.
     */
    const USER_UPDATE = 'api.app.user.update'
    const UPLOAD = 'lu.upload.file'

    const auth = useAuthStore()

    const name = ref(auth.user?.name ?? '')
    const email = ref(auth.user?.email ?? '')

    watch(() => auth.user, (user) => {
        name.value = user?.name ?? ''
        email.value = user?.email ?? ''
    })

    const updateUser = (data) => http.put(apiUrl(USER_UPDATE), { user_id: auth.user?.id, ...data })

    const {
        form: accountForm,
        busy: accountBusy,
        error: accountError,
        handleSubmit: saveAccount,
    } = useValidatedForm(async () => {
        await updateUser({ name: name.value, email: email.value })
        await auth.load()

        notifySuccess(t('Profile updated'))
    })

    // AVATAR

    const fileId = useId()
    const fileInput = ref(null)
    const uploading = ref(false)
    const avatarError = ref('')

    const avatar = computed(() => avatarOf(auth.user))
    const initials = computed(() => initialsOf(auth.user))

    const describe = (error) => {
        const fields = validationErrors(error)

        return fields ? String(Object.values(fields).flat()[0] ?? '') : errorMessage(error, t)
    }

    // La subida va por axios y no con AvatarInputComponent: ese usa fetch sin
    // la cabecera XSRF, y la ruta de laravel-uploads la exige con la sesión.
    const onAvatarChange = async (event) => {
        const file = event.target.files?.[0]

        event.target.value = ''

        if (! file) {
            return
        }

        if (! file.type.startsWith('image/')) {
            avatarError.value = t('Choose an image file.')

            return
        }

        uploading.value = true
        avatarError.value = ''

        try {
            const body = new FormData()

            body.append('file', file)
            body.append('visibility', 'public')

            const upload = await http.post(apiUrl(UPLOAD), body)
            // `uri` es relativa: sigue valiendo si cambia el dominio.
            const location = upload.data?.uri ?? upload.data?.url

            if (! location) {
                throw new Error('The upload did not return a location.')
            }

            await updateUser({ avatar: location })
            await auth.load()

            notifySuccess(t('Photo updated'))
        } catch (error) {
            avatarError.value = error?.response ? describe(error) : t('The photo could not be uploaded.')
        } finally {
            uploading.value = false
        }
    }

    // Una meta vacía se borra.
    const removeAvatar = async () => {
        uploading.value = true
        avatarError.value = ''

        try {
            await updateUser({ avatar: '' })
            await auth.load()
        } catch (error) {
            avatarError.value = describe(error)
        } finally {
            uploading.value = false
        }
    }

    // CONTRASEÑA

    const oldPassword = ref('')
    const newPassword = ref('')
    const passwordConfirmation = ref('')

    const {
        form: passwordForm,
        busy: passwordBusy,
        error: passwordError,
        handleSubmit: savePassword,
    } = useValidatedForm(async () => {
        const data = await auth.updatePassword({
            old_password: oldPassword.value,
            password: newPassword.value,
            password_confirmation: passwordConfirmation.value,
        })

        oldPassword.value = ''
        newPassword.value = ''
        passwordConfirmation.value = ''

        notifySuccess(data?.message ?? t('Password updated'))
    })

</script>
