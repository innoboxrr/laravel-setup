<template>

    <button
        type="button"
        class="fe-icon-button"
        :aria-label="t('Dark mode')"
        :aria-pressed="ui.isDark ? 'true' : 'false'"
        :title="t('Dark mode')"
        @click="ui.toggleTheme()">
        <IconComponent :name="ui.isDark ? 'mdi:weather-night' : 'mdi:weather-sunny'" />
    </button>

</template>

<script setup>

    import t from 'innoboxrr-i18n'
    import { IconComponent } from 'innoboxrr-form-elements'
    import { useUiStore } from '@app/stores/ui.js'

    const ui = useUiStore()

</script>
