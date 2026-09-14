<template>

    <div class="app-page">

        <header class="app-page-header">
            <div>
                <h1 class="app-page-title">{{ greeting }}</h1>
                <p class="app-page-intro">{{ t('This is your administration panel.') }}</p>
            </div>
        </header>

        <ul class="app-shortcuts">
            <li v-for="item in shortcuts" :key="item.id">

                <a v-if="item.href" :href="item.href" class="app-shortcut" target="_blank" rel="noopener noreferrer">
                    <span class="app-shortcut-icon"><IconComponent :name="item.icon" /></span>
                    <span>{{ item.label }}</span>
                    <IconComponent name="external" :size="11" custom-class="app-nav-external" />
                    <span class="visually-hidden">{{ t('(opens in a new tab)') }}</span>
                </a>

                <RouterLink v-else :to="item.to" class="app-shortcut">
                    <span class="app-shortcut-icon"><IconComponent :name="item.icon" /></span>
                    <span>{{ item.label }}</span>
                </RouterLink>

            </li>
        </ul>

    </div>

</template>

<script setup>

    import { computed } from 'vue'
    import { RouterLink } from 'vue-router'
    import t from 'innoboxrr-i18n'
    import { IconComponent } from 'innoboxrr-form-elements'
    import { adminOnly } from '@app/config.js'
    import { moduleRoutes } from '@app/module.js'
    import { buildMenu, menuShortcuts } from '@app/router/menu.js'
    import { useAuthStore } from '@app/stores/auth.js'
    import { firstNameOf } from './user.js'

    const auth = useAuthStore()

    const greeting = computed(() => {
        const name = firstNameOf(auth.user)

        return name ? t('Hello, :name', { name }) : t('Hello')
    })

    // Una tarjeta por entrada del menú. Sin ninguna, al menos el perfil.
    const shortcuts = computed(() => {
        const items = menuShortcuts(buildMenu(moduleRoutes, { isAdmin: auth.isAdmin, adminOnly, t }))

        return items.length
            ? items
            : [{ id: 'admin.profile', label: t('Profile'), icon: 'mdi:account-circle-outline', to: { name: 'admin.profile' } }]
    })

</script>
