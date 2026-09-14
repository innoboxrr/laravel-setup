<template>

    <MenuComponent :items="items" :label="t('User menu')" placement="bottom-end">

        <template #trigger="{ toggle, triggerProps }">
            <button type="button" class="app-user-button" v-bind="triggerProps" @click="toggle">
                <img v-if="avatar" :src="avatar" alt="" class="app-avatar">
                <span v-else class="app-avatar" aria-hidden="true">{{ initials }}</span>
                <span class="app-user-name">{{ name }}</span>
                <IconComponent name="down" :size="10" />
            </button>
        </template>

    </MenuComponent>

</template>

<script setup>

    import { computed } from 'vue'
    import { useRouter } from 'vue-router'
    import t from 'innoboxrr-i18n'
    import { notifyError } from 'innoboxrr-form-core'
    import { IconComponent, MenuComponent } from 'innoboxrr-form-elements'
    import { errorMessage } from '@app/http.js'
    import { useAuthStore } from '@app/stores/auth.js'
    import { avatarOf, initialsOf } from '../user.js'

    const router = useRouter()
    const auth = useAuthStore()

    const avatar = computed(() => avatarOf(auth.user))
    const initials = computed(() => initialsOf(auth.user))
    const name = computed(() => auth.user?.name ?? auth.user?.email ?? '')

    const logout = async () => {
        try {
            await auth.logout()
        } catch (error) {
            // La sesión local ya se limpió: se avisa, pero se sale igual.
            notifyError(errorMessage(error, t))
        }

        await router.replace({ name: 'auth.login' })
    }

    const items = computed(() => [
        { id: 'profile', label: t('Profile'), icon: 'mdi:account-circle-outline', action: () => router.push({ name: 'admin.profile' }) },
        { separator: true },
        { id: 'logout', label: t('Sign out'), icon: 'logout', action: logout },
    ])

</script>
