<template>

    <div v-if="! decision" class="site-cookie" role="region" :aria-label="t('Cookie consent')">

        <p class="site-cookie-text">
            {{ text }}
            <SiteLink v-if="filled(policy_link)" :to="asText(policy_link)" class="site-cookie-link">{{ t('Learn more') }}</SiteLink>
        </p>

        <div class="site-cookie-actions">
            <button type="button" class="fe-button fe-button-sm" @click="decide('accepted')">{{ acceptText }}</button>
            <button type="button" class="fe-button-secondary fe-button-sm" @click="decide('rejected')">{{ rejectText }}</button>
        </div>

    </div>

</template>

<script setup>

    import { computed, ref } from 'vue'
    import t from 'innoboxrr-i18n'
    import SiteLink from '../../../SiteLink.vue'
    import { readConsent, writeConsent } from '../../../cookies.js'
    import { asText, filled } from '../../props.js'

    defineOptions({ inheritAttrs: false })

    const props = defineProps(['message', 'accept_text', 'reject_text', 'policy_link'])

    // Una decisión, aceptar o rechazar, se recuerda igual: el aviso no vuelve.
    const decision = ref(readConsent())

    const text = computed(() => (filled(props.message)
        ? asText(props.message)
        : t('We use cookies to make the site work and to remember your preferences.')))

    const acceptText = computed(() => (filled(props.accept_text) ? asText(props.accept_text) : t('Accept')))

    const rejectText = computed(() => (filled(props.reject_text) ? asText(props.reject_text) : t('Reject')))

    const decide = (value) => {
        writeConsent(value)
        decision.value = value
    }

</script>
