<template>

    <div class="fe-shell app-shell" :data-sidebar-open="ui.sidebarOpen ? 'true' : 'false'">

        <a class="app-skip-link" href="#admin-main">{{ t('Skip to content') }}</a>

        <header class="fe-shell-header app-header">

            <button
                ref="menuButton"
                type="button"
                class="fe-icon-button app-menu-button"
                :aria-expanded="ui.sidebarOpen ? 'true' : 'false'"
                :aria-controls="sidebarId"
                :aria-label="t('Menu')"
                @click="ui.toggleSidebar()">
                <IconComponent name="menu" />
            </button>

            <RouterLink :to="{ name: 'admin.dashboard' }" class="app-brand">{{ siteName }}</RouterLink>

            <span class="app-spacer" />

            <NotificationsBell />

            <ThemeToggle />

            <UserMenu />

        </header>

        <!-- El fondo del menú en móvil: tocar fuera lo cierra. -->
        <div v-if="ui.sidebarOpen" class="app-backdrop" @click="closeSidebar(true)" />

        <nav :id="sidebarId" ref="sidebar" class="fe-shell-sidebar app-sidebar" :aria-label="t('Administration menu')">
            <AdminSidebar :groups="menu" @navigate="closeSidebar()" />
        </nav>

        <main id="admin-main" class="fe-shell-main app-main" tabindex="-1">
            <AdminBanners />
            <RouterView />
        </main>

    </div>

</template>

<script setup>

    import { computed, nextTick, onBeforeUnmount, onMounted, ref, useId, watch } from 'vue'
    import { RouterLink, RouterView, useRoute } from 'vue-router'
    import t from 'innoboxrr-i18n'
    import { IconComponent } from 'innoboxrr-form-elements'
    import { adminOnly } from '@app/config.js'
    import { moduleRoutes } from '@app/module.js'
    import { buildMenu } from '@app/router/menu.js'
    import { useAuthStore } from '@app/stores/auth.js'
    import { startUnreadPolling, useNotificationsStore } from '@app/stores/notifications.js'
    import { useOptionsStore } from '@app/stores/options.js'
    import { useUiStore } from '@app/stores/ui.js'
    import AdminBanners from './components/AdminBanners.vue'
    import AdminSidebar from './components/AdminSidebar.vue'
    import NotificationsBell from './components/NotificationsBell.vue'
    import ThemeToggle from './components/ThemeToggle.vue'
    import UserMenu from './components/UserMenu.vue'

    const route = useRoute()
    const auth = useAuthStore()
    const options = useOptionsStore()
    const ui = useUiStore()
    const notifications = useNotificationsStore()

    const sidebarId = useId()
    const sidebar = ref(null)
    const menuButton = ref(null)

    const siteName = computed(() => options.option('site_name') || t('Administrator'))

    const menu = computed(() => buildMenu(moduleRoutes, { isAdmin: auth.isAdmin, adminOnly, t }))

    const isNarrow = () => globalThis.matchMedia?.('(max-width: 959px)').matches ?? false

    const closeSidebar = (returnFocus = false) => {
        if (! ui.sidebarOpen) {
            return
        }

        ui.closeSidebar()

        if (returnFocus) {
            nextTick(() => menuButton.value?.focus())
        }
    }

    watch(() => ui.sidebarOpen, async (opened) => {
        if (opened && isNarrow()) {
            await nextTick()
            sidebar.value?.querySelector('a')?.focus()
        }
    })

    watch(() => route.fullPath, () => closeSidebar())

    const onKeydown = (event) => {
        if (event.key === 'Escape' && ui.sidebarOpen) {
            closeSidebar(true)
        }
    }

    let stopPolling = () => {}

    onMounted(() => {
        document.addEventListener('keydown', onKeydown)
        stopPolling = startUnreadPolling(notifications)
    })

    onBeforeUnmount(() => {
        document.removeEventListener('keydown', onKeydown)
        stopPolling()
        ui.closeSidebar()
    })

</script>
