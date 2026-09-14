<template>

    <RouterView />

    <!-- Una sola vez en toda la aplicación: aquí pintan sus avisos y sus
         confirmaciones las pantallas propias y las que genera LaraPack. -->
    <ToastRegionComponent :label="t('Notifications')" :close-label="t('Close')" />

    <ConfirmHostComponent :close-label="t('Close')" />

</template>

<script setup>

    import { RouterView } from 'vue-router'
    import t from 'innoboxrr-i18n'
    import { ConfirmHostComponent, ToastRegionComponent } from 'innoboxrr-form-elements'

</script>
