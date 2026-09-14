<template>

    <div class="app-page">

        <header class="app-page-header">
            <div>
                <h1 class="app-page-title">{{ t('Site') }}</h1>
                <p class="app-page-intro">{{ t('The name, the description and the pages of the public site.') }}</p>
            </div>
        </header>

        <p v-if="saveError" class="app-alert" role="alert">{{ saveError }}</p>

        <section class="fe-surface app-card" aria-labelledby="editor-general">
            <h2 id="editor-general" class="app-card-title">{{ t('General') }}</h2>
            <div class="editor-grid">
                <FormField v-model="siteName" name="site_name" :label="t('Site name')" />
                <FormField v-model="siteDescription" name="site_description" :label="t('Site description')" />
            </div>
        </section>

        <section class="fe-surface app-card" aria-labelledby="editor-pages">
            <h2 id="editor-pages" class="app-card-title">{{ t('Pages') }}</h2>

            <div class="editor-tabs" role="tablist" :aria-label="t('Pages')">
                <button
                    v-for="(page, index) in pages"
                    :id="tabId(page.key)"
                    :key="page.key"
                    :ref="(element) => { tabs[index] = element }"
                    type="button"
                    role="tab"
                    class="editor-tab"
                    :aria-selected="page.key === activeKey ? 'true' : 'false'"
                    :aria-controls="panelId(page.key)"
                    :tabindex="page.key === activeKey ? 0 : -1"
                    @click="activeKey = page.key"
                    @keydown="onTabKeydown($event, index)">
                    {{ pageLabel(page) }}
                    <span v-if="pageHasErrors(page)" class="fe-badge fe-badge-danger">{{ t('Error') }}</span>
                </button>
            </div>

            <div
                v-if="activePage"
                :id="panelId(activePage.key)"
                role="tabpanel"
                :aria-labelledby="tabId(activePage.key)"
                class="editor-panel">

                <div class="editor-page-head">
                    <FormField v-model="activePage.title" :name="`page-title-${activePage.key}`" :label="t('Page title')" />
                    <a :href="pageUrl(activePage.key)" class="fe-button-secondary fe-button-sm" target="_blank" rel="noopener noreferrer">
                        {{ t('View page') }}
                        <IconComponent name="external" :size="11" />
                        <span class="visually-hidden">{{ t('(opens in a new tab)') }}</span>
                    </a>
                </div>

                <p v-if="! activePage.sections.length" class="editor-empty">{{ t('This page has no sections yet.') }}</p>

                <ol v-else class="editor-sections">
                    <li
                        v-for="(section, index) in activePage.sections"
                        :key="section.uid"
                        class="editor-section"
                        :data-invalid="isInvalid(section) ? 'true' : 'false'"
                        :data-hidden="sectionVisible(section) === false ? 'true' : 'false'">

                        <div class="editor-section-row">

                            <span class="editor-section-order" aria-hidden="true">{{ index + 1 }}</span>

                            <span class="editor-section-name">
                                {{ section.rest.name || t('Untitled section') }}
                                <small>{{ sectionKeyOf(section) }}</small>
                            </span>

                            <span v-if="isInvalid(section)" class="fe-badge fe-badge-danger">{{ t('Invalid JSON') }}</span>
                            <span v-else-if="! isRegistered(section)" class="fe-badge fe-badge-warning">{{ t('Unknown section') }}</span>

                            <label class="editor-switch">
                                <input
                                    type="checkbox"
                                    role="switch"
                                    :checked="sectionVisible(section) !== false"
                                    :disabled="isInvalid(section)"
                                    :aria-label="t('Show :name', { name: sectionName(section) })"
                                    @change="setDisplay(section, $event.target.checked)">
                                <span aria-hidden="true">{{ t('Visible') }}</span>
                            </label>

                            <span class="editor-section-tools">
                                <button
                                    type="button"
                                    class="fe-icon-button"
                                    :disabled="index === 0"
                                    :aria-label="t('Move :name up', { name: sectionName(section) })"
                                    @click="move(index, -1)">
                                    <IconComponent name="up" :size="14" />
                                </button>
                                <button
                                    type="button"
                                    class="fe-icon-button"
                                    :disabled="index === activePage.sections.length - 1"
                                    :aria-label="t('Move :name down', { name: sectionName(section) })"
                                    @click="move(index, 1)">
                                    <IconComponent name="down" :size="14" />
                                </button>
                                <button
                                    type="button"
                                    class="fe-icon-button"
                                    :aria-expanded="expanded[section.uid] ? 'true' : 'false'"
                                    :aria-controls="`editor-props-${section.uid}`"
                                    :aria-label="t('Edit the props of :name', { name: sectionName(section) })"
                                    @click="expanded[section.uid] = ! expanded[section.uid]">
                                    <IconComponent name="edit" :size="14" />
                                </button>
                                <button
                                    type="button"
                                    class="fe-icon-button fe-icon-button-danger"
                                    :aria-label="t('Remove :name', { name: sectionName(section) })"
                                    @click="remove(index)">
                                    <IconComponent name="delete" :size="14" />
                                </button>
                            </span>

                        </div>

                        <div v-if="expanded[section.uid]" :id="`editor-props-${section.uid}`" class="editor-props">
                            <span class="editor-props-label">{{ t('Props (JSON)') }}</span>
                            <CodeMirrorComponent v-model="section.propsText" lang="json" placeholder="{}" />
                            <p v-if="isInvalid(section)" class="fe-error" role="alert">{{ propsError(section) }}</p>
                        </div>

                    </li>
                </ol>

                <div class="editor-add">
                    <label :for="addId" class="visually-hidden">{{ t('Section to add') }}</label>
                    <select :id="addId" v-model="newSection" class="fe-select">
                        <option v-for="key in registryKeys" :key="key" :value="key">{{ key }}</option>
                    </select>
                    <button type="button" class="fe-button-secondary" @click="add">
                        <IconComponent name="plus" :size="12" />
                        {{ t('Add section') }}
                    </button>
                </div>

            </div>
        </section>

        <div class="editor-savebar">
            <span class="editor-savebar-status" role="status">{{ statusText }}</span>
            <button type="button" class="fe-button" :disabled="saving || hasErrors" @click="save">
                {{ saving ? t('Saving…') : t('Save') }}
            </button>
        </div>

    </div>

</template>

<script setup>

    import { computed, reactive, ref, useId } from 'vue'
    import { useRouter } from 'vue-router'
    import t from 'innoboxrr-i18n'
    import { notifyError, notifySuccess } from 'innoboxrr-form-core'
    import { CodeMirrorComponent, IconComponent } from 'innoboxrr-form-elements'
    import FormField from '@app/components/FormField.vue'
    import { errorMessage, validationErrors } from '@app/http.js'
    import registry from '@app/site/sections/index.js'
    import { useOptionsStore } from '@app/stores/options.js'
    import {
        addSection,
        buildTheme,
        createDraft,
        draftErrors,
        moveSection,
        parseProps,
        removeSection,
        sectionKeyOf,
        sectionVisible,
        setDisplay,
    } from './site-editor.js'

    const options = useOptionsStore()
    const router = useRouter()

    const registryKeys = Object.keys(registry)

    const pages = reactive(createDraft(options.option('theme', {})))
    const siteName = ref(String(options.option('site_name', '') ?? ''))
    const siteDescription = ref(String(options.option('site_description', '') ?? ''))

    const activeKey = ref(pages[0]?.key ?? null)
    const expanded = reactive({})
    const tabs = ref([])
    const newSection = ref(registryKeys[0] ?? '')
    const saving = ref(false)
    const saveError = ref('')
    const addId = useId()
    const uid = useId()

    const snapshot = () => JSON.stringify({
        theme: buildTheme(pages).theme,
        siteName: siteName.value,
        siteDescription: siteDescription.value,
    })

    const saved = ref(snapshot())

    const activePage = computed(() => pages.find((page) => page.key === activeKey.value) ?? null)

    const hasErrors = computed(() => draftErrors(pages).length > 0)

    const dirty = computed(() => hasErrors.value || snapshot() !== saved.value)

    const statusText = computed(() => {
        if (hasErrors.value) {
            return t('Fix the invalid JSON to save.')
        }

        return dirty.value ? t('Unsaved changes') : ''
    })

    const tabId = (key) => `${uid}-tab-${key}`
    const panelId = (key) => `${uid}-panel-${key}`

    const pageLabel = (page) => page.title || page.key

    const pageHasErrors = (page) => page.sections.some((section) => parseProps(section.propsText).error)

    const isInvalid = (section) => parseProps(section.propsText).error !== null

    const isRegistered = (section) => Object.hasOwn(registry, sectionKeyOf(section))

    const sectionName = (section) => section.rest.name || sectionKeyOf(section)

    const propsError = (section) => (parseProps(section.propsText).error === 'not-object'
        ? t('The props must be a JSON object.')
        : t('This is not valid JSON.'))

    const pageUrl = (key) => (router.hasRoute(`site.${key}`) ? router.resolve({ name: `site.${key}` }).href : `/${key}`)

    const onTabKeydown = (event, index) => {
        const moves = { ArrowRight: index + 1, ArrowLeft: index - 1, Home: 0, End: pages.length - 1 }

        if (! (event.key in moves)) {
            return
        }

        event.preventDefault()

        const next = (moves[event.key] + pages.length) % pages.length

        activeKey.value = pages[next].key
        tabs.value[next]?.focus()
    }

    const move = (index, offset) => moveSection(activePage.value.sections, index, offset)

    const remove = (index) => {
        const section = removeSection(activePage.value.sections, index)

        if (section) {
            delete expanded[section.uid]
        }
    }

    const add = () => {
        if (! newSection.value || ! activePage.value) {
            return
        }

        const section = addSection(activePage.value.sections, newSection.value)

        expanded[section.uid] = true
    }

    const save = async () => {
        saveError.value = ''

        const { theme, errors } = buildTheme(pages)

        if (errors.length > 0) {
            activeKey.value = errors[0].page
            expanded[errors[0].uid] = true
            notifyError(t('Fix the invalid JSON before saving.'))

            return
        }

        saving.value = true

        try {
            if (siteName.value !== options.option('site_name', '')) {
                await options.save('site_name', siteName.value)
            }

            if (siteDescription.value !== options.option('site_description', '')) {
                await options.save('site_description', siteDescription.value)
            }

            await options.save('theme', theme)

            saved.value = snapshot()
            notifySuccess(t('Site saved'))
        } catch (error) {
            const fields = validationErrors(error)

            saveError.value = fields ? Object.values(fields).flat().join(' ') : errorMessage(error, t)
            notifyError(saveError.value)
        } finally {
            saving.value = false
        }
    }

</script>
