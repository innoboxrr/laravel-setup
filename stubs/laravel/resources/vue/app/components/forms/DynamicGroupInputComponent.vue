<template>
    <div>
        <label 
            v-if="label"
            class="block mb-4 ml-2 text-sm font-medium text-gray-900 dark:text-white">
            {{ label }}
        </label>
        <div 
            v-for="(group, groupIndex) in value" 
            :key="groupIndex" 
            class="relative"
            :class="{
                'mb-12': groupIndex < value.length - 1,
                'mb-4': groupIndex === value.length - 1
            }">
            <div v-for="(field, fieldIndex) in inputsConfig" :key="fieldIndex">
                <component 
                    :is="resolveComponent(field.type)"
                    v-model="group[field.key]"
                    v-bind="getFieldAttributes(field, groupIndex, fieldIndex)"
                >
                    <template v-if="field.type === 'select'" v-for="option in field.options" :key="option.value">
                        <option :value="option.value">{{ option.text }}</option>
                    </template>
                </component>
            </div>
            <button 
                @click.prevent="removeGroup(groupIndex)" 
                class="absolute -bottom-12 right-0 inline-flex items-center gap-x-1.5 rounded-md bg-red-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
                {{ removeButtonLabel || __('Remove') }}
            </button>
        </div>
        <button 
            @click.prevent="addGroup" 
            class="inline-flex items-center gap-x-1.5 rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
            {{ addButtonLabel || __('Add') }}
        </button>
    </div>
</template>

<script>
    import {
        TextInputComponent,  
        SelectInputComponent,
        TextareaInputComponent,
        EditorInputComponent
    } from "innoboxrr-form-elements";

    export default {
        components: {
            TextInputComponent,
            SelectInputComponent,
            TextareaInputComponent,
            EditorInputComponent
        },
        props: {
            modelValue: {
                type: Array,
                required: true
            },
            inputsConfig: {
                type: Array,
                required: true
            },
            label: {
                type: String,
                default: ''
            },
            addButtonLabel: {
                type: String,
                default: ''
            },
            removeButtonLabel: {
                type: String,
                default: ''
            },
            hasSufix: {
                type: Boolean,
                default: true
            }
        },
        computed: {
            value: {
                get() {
                    return this.modelValue;
                },
                set(value) {
                    this.$emit('update:modelValue', value);
                }
            }
        },
        methods: {
            resolveComponent(type) {
                const components = {
                    text: 'TextInputComponent',
                    editor: 'EditorInputComponent',
                    select: 'SelectInputComponent',
                    textarea: 'TextareaInputComponent',
                };
                return components[type] || 'div'; // Fallback component
            },
            addGroup() {
                const newGroup = {};
                this.inputsConfig.forEach(field => {
                    newGroup[field.key] = '';
                });
                this.value.push(newGroup);
            },
            removeGroup(index) {
                this.value.splice(index, 1);
            },
            getFieldKey(field, groupIndex) {
                return `${field.key}-${groupIndex}`;
            },
            getFieldAttributes(field, groupIndex, fieldIndex) {
                let label = this.hasSufix ? `${field.attributes.label} #${groupIndex + 1}` : field.attributes.label;
                return {
                    ...field.attributes,
                    id: `${field.key}-${groupIndex}-${fieldIndex}`,
                    name: `${field.key}-${groupIndex}-${fieldIndex}`,
                    label: label,
                };
            }
        }
    };

/**
 * Usage:
    <dynamic-group-input-component 
        :label="__('Learning Outcomes')"
        v-model="groupInputs"
        :inputs-config="[
            {
                key: 'question',
                type: 'text',
                attributes: {
                    type: 'text',
                    name: 'question',
                    label: 'Question',
                    placeholder: 'Question',
                    validators: 'required length',
                    min_length: 3,
                    max_length: 100,
                    customClass: inputClass
                }
            },
            {
                key: 'answer',
                type: 'editor',
                attributes: {
                    id: 'answer',
                    file: true,
                    uploadUrl: fileUploadUrl,
                    onFileUploadSuccess: handleFileUploadSuccess,
                    label: 'Answer',
                    placeholder: 'Answer',
                    height: 200,
                    validators: 'required'
                }
            },
            {
                key: 'category',
                type: 'select',
                attributes: {
                    name: 'category',
                    label: 'Category',
                    customClass: inputClass
                },
                options: [
                    { value: 'option1', text: 'Option 1' },
                    { value: 'option2', text: 'Option 2' },
                    { value: 'option3', text: 'Option 3' }
                ]
            }
        ]" 
    />
 */
</script>
