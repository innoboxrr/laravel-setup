<template>

    <div ref="root" class="app-bell" @keydown.esc="close(true)">

        <button
            ref="button"
            type="button"
            class="fe-icon-button app-bell-button"
            :aria-expanded="open ? 'true' : 'false'"
            :aria-controls="panelId"
            :aria-label="buttonLabel"
            @click="toggle">
            <IconComponent name="mdi:bell-outline" />
            <span v-if="store.unread > 0" class="app-bell-count" aria-hidden="true">{{ countText }}</span>
        </button>

        <div v-if="open" :id="panelId" class="fe-surface-raised app-bell-panel" role="region" :aria-label="t('Notifications')">

            <div class="app-bell-head">
                <strong>{{ t('Notifications') }}</strong>
                <button v-if="hasUnread" type="button" class="fe-button-link fe-text-sm" @click="markAll">
                    {{ t('Mark all as read') }}
                </button>
            </div>

            <p v-if="failed" class="app-bell-empty" role="alert">{{ t('The notifications could not be loaded.') }}</p>

            <p v-else-if="store.loading && ! store.items.length" class="app-bell-empty">{{ t('Loading…') }}</p>

            <p v-else-if="! store.items.length" class="app-bell-empty">{{ t('You have no notifications.') }}</p>

            <ul v-else class="app-bell-list">
                <li v-for="notification in store.items" :key="notification.id">
                    <button
                        type="button"
                        class="app-bell-item"
                        :data-unread="notification.read_at ? 'false' : 'true'"
                        @click="openNotification(notification)">
                        <!-- Siempre como texto: el mensaje lo arma quien envía la
                             notificación y puede traer lo que sea. -->
                        <span class="app-bell-message">{{ notificationMessage(notification) }}</span>
                        <span v-if="dateOf(notification)" class="app-bell-time">{{ dateOf(notification) }}</span>
                        <span v-if="! notification.read_at" class="visually-hidden">{{ t('Unread') }}</span>
                    </button>
                </li>
            </ul>

        </div>

    </div>

</template>

<script setup>

    import { computed, nextTick, onBeforeUnmount, onMounted, ref, useId } from 'vue'
    import { useRouter } from 'vue-router'
    import t, { getLocale } from 'innoboxrr-i18n'
    import { notifyError } from 'innoboxrr-form-core'
    import { IconComponent } from 'innoboxrr-form-elements'
    import { errorMessage } from '@app/http.js'
    import { notificationMessage, resolveAction, useNotificationsStore } from '@app/stores/notifications.js'

    const store = useNotificationsStore()
    const router = useRouter()

    const root = ref(null)
    const button = ref(null)
    const open = ref(false)
    const failed = ref(false)
    const panelId = useId()

    const hasUnread = computed(() => store.unread > 0 || store.items.some((item) => ! item.read_at))

    const countText = computed(() => (store.unread > 99 ? '99+' : String(store.unread)))

    const buttonLabel = computed(() => (store.unread > 0
        ? t('Notifications, :count unread', { count: store.unread })
        : t('Notifications')))

    const dateOf = (notification) => {
        const date = notification?.created_at ? new Date(notification.created_at) : null

        if (! date || Number.isNaN(date.getTime())) {
            return ''
        }

        try {
            return new Intl.DateTimeFormat(getLocale(), { dateStyle: 'medium', timeStyle: 'short' }).format(date)
        } catch {
            return date.toLocaleString()
        }
    }

    const close = (returnFocus = false) => {
        if (! open.value) {
            return
        }

        open.value = false

        if (returnFocus) {
            nextTick(() => button.value?.focus())
        }
    }

    const toggle = async () => {
        if (open.value) {
            close()

            return
        }

        open.value = true
        failed.value = false

        try {
            await store.fetchLatest()
        } catch {
            failed.value = true
        }
    }

    const openNotification = async (notification) => {
        let action = notification.data?.action ?? null

        try {
            action = await store.markAsRead(notification)
        } catch (error) {
            notifyError(errorMessage(error, t))
        }

        close()

        const target = resolveAction(action)

        if (target?.type === 'router') {
            router.push(target.to)
        } else if (target?.type === 'location') {
            window.location.assign(target.href)
        }
    }

    const markAll = async () => {
        try {
            await store.markAllAsRead()
        } catch (error) {
            notifyError(errorMessage(error, t))
        }
    }

    const onDocumentClick = (event) => {
        if (open.value && root.value && ! root.value.contains(event.target)) {
            close()
        }
    }

    onMounted(() => document.addEventListener('click', onDocumentClick, true))

    onBeforeUnmount(() => document.removeEventListener('click', onDocumentClick, true))

</script>
