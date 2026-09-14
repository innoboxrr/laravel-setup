<template>

    <div class="app-field">

        <label :for="id" class="fe-label">{{ label }}</label>

        <!-- js-validator escribe el mensaje de error justo después del control. -->
        <input
            :id="id"
            v-model="model"
            class="fe-input"
            :type="type"
            :name="name"
            :autocomplete="autocomplete"
            :data-validators="validators || undefined"
            :aria-required="required ? 'true' : undefined"
            :aria-describedby="hint ? hintId : undefined"
            v-bind="$attrs">

        <p v-if="hint" :id="hintId" class="app-field-hint">{{ hint }}</p>

    </div>

</template>

<script setup>

    /**
     * Un campo con su etiqueta enlazada por `for`/`id`. El TextInputComponent de
     * form-elements no da `id` al control, así que su etiqueta no lo nombra para
     * un lector de pantalla.
     */

    import { computed, useId } from 'vue'

    defineOptions({ inheritAttrs: false })

    const model = defineModel({ default: '' })

    const props = defineProps({
        label: { type: String, required: true },
        name: { type: String, required: true },
        type: { type: String, default: 'text' },
        autocomplete: { type: String, default: null },
        validators: { type: String, default: null },
        hint: { type: String, default: null },
    })

    const id = useId()

    const hintId = `${id}-hint`

    const required = computed(() => (props.validators ?? '').split(/[\s|]+/).includes('required'))

</script>
