import { h } from 'vue'

/**
 * Lo que la aplicación usa de innoboxrr-form-elements, tomado de sus fuentes
 * uno a uno. CodeMirror no se puede montar en jsdom: aquí es un <textarea> con
 * el mismo v-model, que es lo único que el editor del sitio le pide.
 */

export { default as ConfirmHostComponent } from 'innoboxrr-form-elements/src/ConfirmHostComponent.vue'
export { default as DialogComponent } from 'innoboxrr-form-elements/src/DialogComponent.vue'
export { default as IconComponent } from 'innoboxrr-form-elements/src/IconComponent.vue'
export { default as MenuComponent } from 'innoboxrr-form-elements/src/MenuComponent.vue'
export { default as ToastRegionComponent } from 'innoboxrr-form-elements/src/ToastRegionComponent.vue'

export const CodeMirrorComponent = {
    name: 'CodeMirrorComponent',
    props: {
        modelValue: { type: String, default: '' },
        lang: { type: String, default: 'html' },
        label: { type: String, default: '' },
        placeholder: { type: String, default: '' },
    },
    emits: ['update:modelValue'],
    setup(props, { emit }) {
        return () => h('textarea', {
            class: 'codemirror-stub',
            'data-lang': props.lang,
            value: props.modelValue,
            onInput: (event) => emit('update:modelValue', event.target.value),
        })
    },
}
