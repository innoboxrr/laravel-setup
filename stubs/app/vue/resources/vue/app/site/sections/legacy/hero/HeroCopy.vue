<template>

    <div class="site-hero-copy">

        <p v-if="filled(badge) || filled(badgeValue)" class="site-hero-badge">
            <SiteLink v-if="filled(badge)" :to="badgeLink" class="fe-badge fe-badge-primary">{{ badge }}</SiteLink>
            <SiteLink v-if="filled(badgeValue)" :to="badgeValueLink || badgeLink" class="site-hero-badge-value">
                {{ badgeValue }}
                <IconComponent name="next" :size="10" />
            </SiteLink>
        </p>

        <h1 v-if="filled(title)" class="site-title site-display">{{ title }}</h1>

        <p v-if="filled(message)" class="site-lead">{{ message }}</p>

        <div v-if="filled(primaryText) || filled(secondaryText) || $slots.actions" class="site-actions">
            <SiteLink v-if="filled(primaryText)" :to="primaryLink" class="fe-button site-button-lg">{{ primaryText }}</SiteLink>
            <SiteLink v-if="filled(secondaryText)" :to="secondaryLink" class="site-link-arrow">
                {{ secondaryText }} <span aria-hidden="true">→</span>
            </SiteLink>
            <slot name="actions" />
        </div>

    </div>

</template>

<script setup>

    /**
     * El texto que comparten los tres héroes. No está en el registro: es una
     * pieza de HeroOne, HeroTwo y HeroThree.
     */

    import { IconComponent } from 'innoboxrr-form-elements'
    import SiteLink from '../../../SiteLink.vue'
    import { filled } from '../../props.js'

    defineProps({
        badge: { default: '' },
        badgeValue: { default: '' },
        badgeLink: { default: '' },
        badgeValueLink: { default: '' },
        title: { default: '' },
        message: { default: '' },
        primaryText: { default: '' },
        primaryLink: { default: '' },
        secondaryText: { default: '' },
        secondaryLink: { default: '' },
    })

</script>
