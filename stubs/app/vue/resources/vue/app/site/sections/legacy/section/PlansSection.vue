<template>

    <section class="site-section site-section-alt">

        <div class="site-container">

            <div v-if="filled(title) || filled(subtitle)" class="site-heading-center">
                <h2 v-if="filled(title)" class="site-title">{{ title }}</h2>
                <p v-if="filled(subtitle)" class="site-lead">{{ subtitle }}</p>
            </div>

            <fieldset v-if="periods.length > 1" class="site-segmented">
                <legend class="visually-hidden">{{ t('Billing frequency') }}</legend>
                <label v-for="period in periods" :key="period.value" class="site-segmented-option">
                    <input v-model="selected" type="radio" :name="groupName" :value="period.value" class="site-segmented-input">
                    <span>{{ period.label }}</span>
                </label>
            </fieldset>

            <ul v-if="plans.length" class="site-tiers">
                <li
                    v-for="plan in plans"
                    :key="plan.key"
                    class="site-card site-tier"
                    :data-popular="plan.popular ? 'true' : 'false'"
                    :aria-labelledby="plan.headingId">

                    <div class="site-tier-head">
                        <h3 :id="plan.headingId" class="site-tier-name">{{ plan.name }}</h3>
                        <span v-if="plan.popular" class="fe-badge fe-badge-primary">{{ t('Most popular') }}</span>
                    </div>

                    <p v-if="plan.description" class="site-text">{{ plan.description }}</p>

                    <p v-if="priceOf(plan)" class="site-tier-price">
                        <span class="site-tier-amount">{{ priceOf(plan) }}</span>
                        <span v-if="suffix" class="site-tier-suffix">{{ suffix }}</span>
                    </p>

                    <SiteLink
                        v-if="plan.href"
                        :to="plan.href"
                        :class="plan.popular ? 'fe-button' : 'fe-button-secondary'"
                        class="site-tier-cta"
                        :aria-describedby="plan.headingId">{{ t('Choose plan') }}</SiteLink>

                    <ul v-if="plan.features.length" class="site-check-list">
                        <li v-for="(feature, index) in plan.features" :key="index">
                            <IconComponent name="check" :size="14" custom-class="site-check-icon" />
                            <span>{{ feature }}</span>
                        </li>
                    </ul>

                </li>
            </ul>

        </div>

    </section>

</template>

<script setup>

    import { computed, ref, useId, watch } from 'vue'
    import t from 'innoboxrr-i18n'
    import { IconComponent } from 'innoboxrr-form-elements'
    import SiteLink from '../../../SiteLink.vue'
    import { asArray, asObject, asText, filled, isTruthy, textList } from '../../props.js'

    defineOptions({ inheritAttrs: false })

    const props = defineProps(['title', 'subtitle', 'frequencies', 'tiers'])

    const groupName = useId()

    const periods = computed(() => asArray(props.frequencies)
        .map(asObject)
        .filter((item) => filled(item.value))
        .map((item) => ({
            value: asText(item.value),
            label: filled(item.label) ? asText(item.label) : asText(item.value),
            suffix: asText(item.price_suffix),
        })))

    const selected = ref(periods.value[0]?.value ?? null)

    watch(periods, (list) => {
        if (! list.some((period) => period.value === selected.value)) {
            selected.value = list[0]?.value ?? null
        }
    })

    const suffix = computed(() => periods.value.find((period) => period.value === selected.value)?.suffix ?? '')

    const plans = computed(() => asArray(props.tiers)
        .map(asObject)
        .filter((tier) => filled(tier.name))
        .map((tier, index) => ({
            key: filled(tier.id) ? asText(tier.id) : String(index),
            headingId: `${groupName}-${index}`,
            name: asText(tier.name),
            href: asText(tier.href),
            description: asText(tier.description),
            price: tier.price,
            features: textList(tier.features),
            popular: isTruthy(tier.most_popular),
        })))

    // El precio de la frecuencia elegida; sin frecuencias, un precio suelto o
    // el primero que haya.
    const priceOf = (plan) => {
        if (typeof plan.price === 'string' || typeof plan.price === 'number') {
            return asText(plan.price)
        }

        const prices = asObject(plan.price)

        if (selected.value !== null) {
            return asText(prices[selected.value])
        }

        return asText(Object.values(prices)[0])
    }

</script>
