<template>

    <div class="app-nav">

        <div v-for="group in groups" :key="group.id" class="app-nav-group">

            <p v-if="group.label" :id="`app-nav-${group.id}`" class="app-nav-heading">{{ group.label }}</p>

            <ul class="app-nav-list" :aria-labelledby="group.label ? `app-nav-${group.id}` : undefined">

                <li v-for="item in group.items" :key="item.id">

                    <a
                        v-if="item.href"
                        :href="item.href"
                        class="app-nav-link"
                        target="_blank"
                        rel="noopener noreferrer"
                        @click="emit('navigate')">
                        <IconComponent :name="item.icon" :size="16" />
                        <span>{{ item.label }}</span>
                        <IconComponent name="external" :size="11" custom-class="app-nav-external" />
                        <span class="visually-hidden">{{ t('(opens in a new tab)') }}</span>
                    </a>

                    <RouterLink v-else :to="item.to" class="app-nav-link" @click="emit('navigate')">
                        <IconComponent :name="item.icon" :size="16" />
                        <span>{{ item.label }}</span>
                    </RouterLink>

                </li>

            </ul>

        </div>

    </div>

</template>

<script setup>

    import { RouterLink } from 'vue-router'
    import t from 'innoboxrr-i18n'
    import { IconComponent } from 'innoboxrr-form-elements'

    defineProps({
        groups: { type: Array, default: () => [] },
    })

    const emit = defineEmits(['navigate'])

</script>
